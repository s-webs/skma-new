<?php

namespace App\Http\Controllers\Ai;

use App\Http\Controllers\Controller;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Str;

class AiCheckController extends Controller
{
    public function index()
    {
        return view('pages.ai.ai-check', [
            'conclusion' => session('ai_check_conclusion'),
            'errorDetails' => session('errorDetails'),
        ]);
    }

    private function normalizeConclusion(mixed $payload): ?string
    {
        // 1) Если пришёл массив (часто n8n отдаёт [{...}])
        if (is_array($payload)) {
            // если это массив элементов, берём первый
            if (isset($payload[0])) {
                return $this->normalizeConclusion($payload[0]);
            }

            // если в массиве есть нужные ключи
            foreach (['conclusion', 'result', 'output', 'text'] as $k) {
                if (array_key_exists($k, $payload)) {
                    return $this->normalizeConclusion($payload[$k]);
                }
            }

            return trim(json_encode($payload, JSON_UNESCAPED_UNICODE));
        }

        // 2) Если пришёл объект
        if (is_object($payload)) {
            // Laravel HTTP json() обычно даёт array, но на всякий случай
            $arr = (array) $payload;
            return $this->normalizeConclusion($arr);
        }

        // 3) Если это строка — чистим markdown и пытаемся вытащить conclusion из JSON
        if (is_string($payload)) {
            $s = trim($payload);

            // убрать ```json ... ``` и любые ```
            $s = preg_replace('/^```(?:json)?\s*/i', '', $s);
            $s = preg_replace('/\s*```$/', '', $s);
            $s = trim($s);

            // если внутри строка вида {"conclusion":"..."} — распарсим
            $decoded = json_decode($s, true);
            if (json_last_error() === JSON_ERROR_NONE && is_array($decoded)) {
                // иногда бывает { "output": "..." } и т.п.
                foreach (['conclusion', 'result', 'output', 'text'] as $k) {
                    if (isset($decoded[$k])) {
                        return $this->normalizeConclusion($decoded[$k]);
                    }
                }

                // если просто JSON, но без ключей — вернём как строку
                return trim(json_encode($decoded, JSON_UNESCAPED_UNICODE));
            }

            // если это строка с экранированными \n и \" — попробуем “разэкранировать”
            // (аккуратно: только если похоже на JSON-строку)
            if (str_contains($s, '\n') || str_contains($s, '\"')) {
                $s2 = stripcslashes($s);
                $decoded2 = json_decode($s2, true);
                if (json_last_error() === JSON_ERROR_NONE && is_array($decoded2)) {
                    foreach (['conclusion', 'result', 'output', 'text'] as $k) {
                        if (isset($decoded2[$k])) {
                            return $this->normalizeConclusion($decoded2[$k]);
                        }
                    }
                    return trim(json_encode($decoded2, JSON_UNESCAPED_UNICODE));
                }
                // если не JSON — вернём разэкраниренный текст
                $s = $s2;
            }

            return $s !== '' ? $s : null;
        }

        // 4) null/прочее
        return $payload !== null ? trim((string) $payload) : null;
    }

    public function check(Request $request)
    {
        $request->validate([
            'document' => [
                'required',
                'file',
                'max:10240', // 10 MB (в KB)

                // MIME-тип (строго под текст)
                'mimetypes:text/plain',

                // Дополнительно проверяем расширение, чтобы точно был .txt
                function ($attribute, $value, $fail) {
                    /** @var \Illuminate\Http\UploadedFile $value */
                    if (strtolower($value->getClientOriginalExtension()) !== 'txt') {
                        $fail('Разрешён только файл формата .txt');
                    }
                },
            ],
        ]);

        $file = $request->file('document');

        $n8nUrl = config('services.n8n.webhook_url');
        if (!$n8nUrl) {
            return redirect()
                ->route('ai.check')
                ->with('conclusion', null)
                ->with('errorDetails', 'N8N_WEBHOOK_URL не настроен в .env');
        }

        // На всякий случай нормализуем имя файла (чтобы точно было .txt)
        $originalName = $file->getClientOriginalName();
        $baseName = pathinfo($originalName, PATHINFO_FILENAME);
        $safeName = $baseName . '.txt';

        try {
            $response = Http::timeout(180)
                ->attach(
                    'document',
                    file_get_contents($file->getRealPath()),
                    $safeName,
                    ['Content-Type' => 'text/plain; charset=utf-8']
                )

                ->post($n8nUrl, [
                    'filename' => $safeName,
                ]);

            if (!$response->successful()) {
                return redirect()
                    ->route('ai.check')
                    ->with('conclusion', null)
                    ->with('errorDetails', 'n8n вернул ошибку: ' . $response->status() . ' ' . $response->body());
            }

            // Берём максимум информации: и json(), и сырой body
            $payload = $response->json();
            $rawBody = $response->body();

            // Пытаемся вытащить conclusion из JSON, иначе из body
            $conclusion = $this->normalizeConclusion(
                $payload['conclusion']
                ?? $payload['result']
                ?? $payload
                ?? $rawBody
            );

            if (!$conclusion) {
                $conclusion = 'Не удалось получить заключение от сервиса проверки.';
            }

            session()->put('ai_check_conclusion', $conclusion);
            session()->put('ai_check_filename', $safeName);

            session()->put('ai_check_filename', $safeName);

            return redirect()
                ->route('ai.check')
                ->with('errorDetails', null);

        } catch (\Throwable $e) {
            return redirect()
                ->route('ai.check')
                ->with('conclusion', null)
                ->with('errorDetails', 'Ошибка запроса к n8n: ' . $e->getMessage());
        }
    }

    public function downloadPdf(Request $request)
    {
        $conclusion = session('ai_check_conclusion');
        $filename = session('ai_check_filename');

        if (!$conclusion) {
            abort(404, 'Нет данных для формирования PDF');
        }

        $safeBase = $filename ? Str::slug(pathinfo($filename, PATHINFO_FILENAME)) : 'ai-check';
        $pdfName = $safeBase . '-conclusion.pdf';

        $pdf = Pdf::loadView('pdf.ai-check-conclusion', [
            'conclusion' => $conclusion,
            'filename' => $filename,
            'generatedAt' => now(),
        ])->setPaper('a4', 'portrait');

        // очистим, чтобы не скачивали старое заключение
        session()->forget(['ai_check_conclusion', 'ai_check_filename']);

        return $pdf->download($pdfName);
    }


}
