<?php

namespace App\Http\Controllers\Ai;

use App\Http\Controllers\Controller;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;
set_time_limit(120);          // 120 секунд
ini_set('max_execution_time', '120');

class AiCheckController extends Controller
{
    public function index()
    {
        return view('pages.ai.ai-check', [
            'conclusion' => session('ai_check_conclusion'),
            'errorDetails' => session('errorDetails'),
        ]);
    }

    public function clearReport()
    {
        session()->forget(['ai_check_conclusion', 'ai_check_filename', 'ai_check_pdf']);

        return redirect()->route('ai.check');
    }

    public function preparePdf(Request $request)
    {
        $conclusionData = session('ai_check_conclusion');
        $filename = session('ai_check_filename');

        if (!$conclusionData) {
            return response()->json(['success' => false, 'error' => 'Нет данных для формирования PDF'], 404);
        }

        if (is_string($conclusionData)) {
            $conclusionData = [
                'overall_assessment' => $conclusionData,
                'risk_level' => 'MEDIUM',
                'major_findings' => [],
                'quality_scores' => [],
                'common_error_patterns' => [],
                'action_plan' => [],
                'spot_check' => [],
            ];
        }

        $headerImagePath = public_path('header_kolontitul.png');
        $stampImagePath = public_path('stamp_test.png');

        $pdf = Pdf::loadView('pdf.ai-check-conclusion', [
            'data' => $conclusionData,
            'filename' => $filename,
            'generatedAt' => now(),
            'headerImagePath' => $headerImagePath,
            'stampImagePath' => $stampImagePath,
        ])->setPaper('a4', 'portrait')
          ->setOption('enable-local-file-access', true)
          ->setOption('isHtml5ParserEnabled', true);

        $pdfBinary = $pdf->output();
        session()->put('ai_check_pdf', $pdfBinary);

        return response()->json(['success' => true]);
    }

    private function parseConclusionJson(mixed $payload): ?array
    {
        // 1) Если пришёл массив (часто n8n отдаёт [{...}])
        if (is_array($payload)) {
            // если это массив элементов, берём первый
            if (isset($payload[0]) && is_array($payload[0])) {
                return $this->parseConclusionJson($payload[0]);
            }

            // если в массиве есть нужные ключи новой схемы
            if (isset($payload['overall_assessment']) || isset($payload['risk_level'])) {
                return $this->validateConclusionSchema($payload);
            }

            // если в массиве есть старые ключи, пытаемся найти JSON внутри
            foreach (['conclusion', 'result', 'output', 'text'] as $k) {
                if (array_key_exists($k, $payload)) {
                    return $this->parseConclusionJson($payload[$k]);
                }
            }

            // если это уже валидная схема
            return $this->validateConclusionSchema($payload);
        }

        // 2) Если пришёл объект
        if (is_object($payload)) {
            $arr = (array) $payload;
            return $this->parseConclusionJson($arr);
        }

        // 3) Если это строка — чистим markdown и пытаемся распарсить JSON
        if (is_string($payload)) {
            $s = trim($payload);

            // убрать ```json ... ``` и любые ```
            $s = preg_replace('/^```(?:json)?\s*/i', '', $s);
            $s = preg_replace('/\s*```$/', '', $s);
            $s = trim($s);

            // пытаемся распарсить JSON
            $decoded = json_decode($s, true);
            if (json_last_error() === JSON_ERROR_NONE && is_array($decoded)) {
                // проверяем на новую схему
                if (isset($decoded['overall_assessment']) || isset($decoded['risk_level'])) {
                    return $this->validateConclusionSchema($decoded);
                }

                // если внутри есть вложенный JSON
                foreach (['conclusion', 'result', 'output', 'text'] as $k) {
                    if (isset($decoded[$k])) {
                        $nested = $this->parseConclusionJson($decoded[$k]);
                        if ($nested !== null) {
                            return $nested;
                        }
                    }
                }

                // если просто JSON, но без ключей — проверяем как схему
                return $this->validateConclusionSchema($decoded);
            }

            // если это строка с экранированными \n и \" — попробуем "разэкранировать"
            if (str_contains($s, '\n') || str_contains($s, '\"')) {
                $s2 = stripcslashes($s);
                $decoded2 = json_decode($s2, true);
                if (json_last_error() === JSON_ERROR_NONE && is_array($decoded2)) {
                    return $this->parseConclusionJson($decoded2);
                }
            }
        }

        return null;
    }

    private function validateConclusionSchema(array $data): ?array
    {
        // Минимальная валидация: должны быть хотя бы основные поля
        if (!isset($data['overall_assessment']) && !isset($data['risk_level'])) {
            return null;
        }

        // Нормализуем данные, заполняя отсутствующие поля пустыми значениями
        return [
            'overall_assessment' => $data['overall_assessment'] ?? '',
            'risk_level' => $data['risk_level'] ?? 'MEDIUM',
            'major_findings' => $data['major_findings'] ?? [],
            'quality_scores' => $data['quality_scores'] ?? [],
            'common_error_patterns' => $data['common_error_patterns'] ?? [],
            'action_plan' => $data['action_plan'] ?? [],
            'spot_check' => $data['spot_check'] ?? [],
        ];
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

        // При проверке нового документа — удалить старый отчёт из сессии
        session()->forget(['ai_check_conclusion', 'ai_check_filename', 'ai_check_pdf']);

        $n8nUrl = config('services.n8n.webhook_url');
        if (!$n8nUrl) {
            $msg = 'N8N_WEBHOOK_URL не настроен в .env';
            if ($request->wantsJson()) {
                return response()->json(['success' => false, 'error' => $msg], 500);
            }

            return redirect()
                ->route('ai.check')
                ->with('conclusion', null)
                ->with('errorDetails', $msg);
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
                $msg = 'n8n вернул ошибку: ' . $response->status() . ' ' . $response->body();
                if ($request->wantsJson()) {
                    return response()->json(['success' => false, 'error' => $msg], 502);
                }

                return redirect()
                    ->route('ai.check')
                    ->with('conclusion', null)
                    ->with('errorDetails', $msg);
            }

            // Берём максимум информации: и json(), и сырой body
            $payload = $response->json();
            $rawBody = $response->body();

            // Логирование ответа n8n для отладки (особенно quality_scores)
            Log::info('AiCheck: ответ n8n', [
                'raw_body' => $rawBody,
                'payload' => $payload,
            ]);

            // Пытаемся распарсить JSON по новой схеме
            $conclusionData = $this->parseConclusionJson(
                $payload['conclusion']
                ?? $payload['result']
                ?? $payload
                ?? $rawBody
            );

            if (!$conclusionData) {
                // Если не удалось распарсить, сохраняем как текст для обратной совместимости
                $conclusionData = [
                    'overall_assessment' => is_string($rawBody) ? $rawBody : 'Не удалось получить заключение от сервиса проверки.',
                    'risk_level' => 'MEDIUM',
                    'major_findings' => [],
                    'quality_scores' => [],
                    'common_error_patterns' => [],
                    'action_plan' => [],
                    'spot_check' => [],
                ];
            }

            session()->put('ai_check_conclusion', $conclusionData);
            session()->put('ai_check_filename', $safeName);

            // Логирование распарсенных данных (в т.ч. quality_scores для отладки блока оценок качества)
            Log::info('AiCheck: распарсенный conclusion', [
                'conclusion_data' => $conclusionData,
                'quality_scores_raw' => $conclusionData['quality_scores'] ?? null,
                'quality_scores_type' => gettype($conclusionData['quality_scores'] ?? null),
            ]);

            if ($request->wantsJson()) {
                return response()->json(['success' => true]);
            }

            return redirect()
                ->route('ai.check')
                ->with('errorDetails', null);

        } catch (\Throwable $e) {
            $msg = 'Ошибка запроса к n8n: ' . $e->getMessage();
            if ($request->wantsJson()) {
                return response()->json(['success' => false, 'error' => $msg], 500);
            }

            return redirect()
                ->route('ai.check')
                ->with('conclusion', null)
                ->with('errorDetails', $msg);
        }
    }

    public function downloadPdf(Request $request)
    {
        $pdfBinary = session('ai_check_pdf');
        $filename = session('ai_check_filename');

        if ($pdfBinary) {
            $safeBase = $filename ? Str::slug(pathinfo($filename, PATHINFO_FILENAME)) : 'ai-check';
            $pdfName = $safeBase . '-conclusion.pdf';

            return response($pdfBinary)
                ->header('Content-Type', 'application/pdf')
                ->header('Content-Disposition', 'attachment; filename="' . $pdfName . '"');
        }

        $conclusionData = session('ai_check_conclusion');
        if (!$conclusionData) {
            abort(404, 'Нет данных для формирования PDF');
        }

        // Если данные в старом формате (строка), преобразуем в новый формат
        if (is_string($conclusionData)) {
            $conclusionData = [
                'overall_assessment' => $conclusionData,
                'risk_level' => 'MEDIUM',
                'major_findings' => [],
                'quality_scores' => [],
                'common_error_patterns' => [],
                'action_plan' => [],
                'spot_check' => [],
            ];
        }

        $safeBase = $filename ? Str::slug(pathinfo($filename, PATHINFO_FILENAME)) : 'ai-check';
        $pdfName = $safeBase . '-conclusion.pdf';

        $headerImagePath = public_path('header_kolontitul.png');
        $stampImagePath = public_path('stamp_test.png');

        $pdf = Pdf::loadView('pdf.ai-check-conclusion', [
            'data' => $conclusionData,
            'filename' => $filename,
            'generatedAt' => now(),
            'headerImagePath' => $headerImagePath,
            'stampImagePath' => $stampImagePath,
        ])->setPaper('a4', 'portrait')
          ->setOption('enable-local-file-access', true)
          ->setOption('isHtml5ParserEnabled', true);

        return $pdf->download($pdfName);
    }


}
