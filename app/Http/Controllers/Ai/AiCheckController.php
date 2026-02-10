<?php

namespace App\Http\Controllers\Ai;

use App\Http\Controllers\Controller;
use App\Jobs\AiCheckAnalyzeJob;
use App\Models\AiCheckJob;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class AiCheckController extends Controller
{
    public function index()
    {
        return view('pages.ai.ai-check', [
            'conclusion' => null,
            'errorDetails' => session('errorDetails'),
        ]);
    }

    public function clearReport()
    {
        session()->forget(['ai_check_conclusion', 'ai_check_filename', 'ai_check_pdf', 'ai_check_pdfs']);

        return redirect()->route('ai.check');
    }

    public function preparePdf(Request $request)
    {
        $pdfs = session('ai_check_pdfs');

        if (!$pdfs || !is_array($pdfs)) {
            return response()->json(['success' => false, 'error' => 'Нет PDF-файлов от сервиса проверки'], 404);
        }

        // Язык можно будет выбирать через параметр ?lang=ru/kk/en, пока — ru по умолчанию
        $lang = $request->get('lang', 'ru');
        $lang = strtolower($lang);
        if (!in_array($lang, ['ru', 'kk', 'en'], true)) {
            $lang = 'ru';
        }

        $pdfBase64 = $pdfs[$lang] ?? null;
        if (!$pdfBase64 || !is_string($pdfBase64)) {
            return response()->json(['success' => false, 'error' => 'Не удалось найти PDF для выбранного языка'], 404);
        }

        $pdfBinary = base64_decode($pdfBase64, true);
        if ($pdfBinary === false) {
            return response()->json(['success' => false, 'error' => 'Ошибка декодирования PDF'], 500);
        }

        session()->put('ai_check_pdf', $pdfBinary);
        session()->put('ai_check_pdf_lang', $lang);

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
                // Максимальный размер: 50 МБ (в килобайтах)
                'max:51200',
                // Разрешаем только Word-документы
                'mimes:doc,docx',
            ],
        ]);

        $file = $request->file('document');

        // При проверке нового документа — удалить старый отчёт из сессии
        session()->forget(['ai_check_conclusion', 'ai_check_filename', 'ai_check_pdf', 'ai_check_pdfs']);

        if (!config('services.aicheck.url')) {
            $msg = 'AICHECK_API_URL не настроен в .env';
            if ($request->wantsJson()) {
                return response()->json(['success' => false, 'error' => $msg], 500);
            }

            return redirect()
                ->route('ai.check')
                ->with('conclusion', null)
                ->with('errorDetails', $msg);
        }

        $originalName = $file->getClientOriginalName();
        $extension = strtolower($file->getClientOriginalExtension());
        $safeBase = Str::slug(pathinfo($originalName, PATHINFO_FILENAME)) ?: 'document';
        $safeName = $safeBase . '.' . $extension;

        $storedPath = $file->storeAs('ai-check/uploads', $safeName);

        $job = AiCheckJob::create([
            'user_id' => Auth::id(),
            'status' => AiCheckJob::STATUS_PENDING,
            'source_filename' => $originalName,
            'stored_path' => $storedPath,
        ]);

        AiCheckAnalyzeJob::dispatch($job->id);

        if ($request->wantsJson()) {
            return response()->json([
                'success' => true,
                'job_id' => $job->id,
            ]);
        }

        return redirect()
            ->route('ai.check')
            ->with('errorDetails', null);
    }

    public function downloadPdf(Request $request)
    {
        abort(404);
    }

    public function status(AiCheckJob $job)
    {
        if ($job->user_id !== Auth::id()) {
            abort(403);
        }

        return response()->json([
            'status' => $job->status,
            'has_result' => $job->status === AiCheckJob::STATUS_DONE && !empty($job->result_json),
            'has_error' => $job->status === AiCheckJob::STATUS_FAILED,
            'error_message' => $job->error_message,
        ]);
    }

    public function result(AiCheckJob $job)
    {
        if ($job->user_id !== Auth::id()) {
            abort(403);
        }

        if ($job->status !== AiCheckJob::STATUS_DONE || empty($job->result_json)) {
            abort(404, 'Результат ещё не готов');
        }

        $assessment = $this->validateConclusionSchema($job->result_json ?? []);

        return view('pages.ai.ai-check-result', [
            'job' => $job,
            'assessment' => $assessment,
        ]);
    }

    public function downloadResultPdf(AiCheckJob $job, string $lang)
    {
        if ($job->user_id !== Auth::id()) {
            abort(403);
        }

        $lang = strtolower($lang);
        if (!in_array($lang, ['ru', 'kk', 'en'], true)) {
            abort(404);
        }

        $field = match ($lang) {
            'kk' => 'pdf_kk_path',
            'en' => 'pdf_en_path',
            default => 'pdf_ru_path',
        };

        $path = $job->{$field};
        if (!$path || !Storage::exists($path)) {
            abort(404, 'PDF не найден');
        }

        $safeBase = Str::slug(pathinfo($job->source_filename, PATHINFO_FILENAME)) ?: 'ai-check';
        $pdfName = $safeBase . "-conclusion-{$lang}.pdf";

        return Storage::download($path, $pdfName, [
            'Content-Type' => 'application/pdf',
        ]);
    }

}
