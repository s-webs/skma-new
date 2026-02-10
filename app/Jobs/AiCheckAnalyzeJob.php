<?php

namespace App\Jobs;

use App\Models\AiCheckJob;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

class AiCheckAnalyzeJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public int $timeout = 180;

    public int $tries = 10;

    public int $jobId;

    /**
     * Create a new job instance.
     */
    public function __construct(int $jobId)
    {
        $this->jobId = $jobId;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        /** @var AiCheckJob|null $job */
        $job = AiCheckJob::find($this->jobId);
        if (!$job) {
            return;
        }

        if (!in_array($job->status, [AiCheckJob::STATUS_PENDING, AiCheckJob::STATUS_PROCESSING], true)) {
            return;
        }

        $job->update([
            'status' => AiCheckJob::STATUS_PROCESSING,
            'error_message' => null,
        ]);

        $serviceUrl = config('services.aicheck.url');
        $apiKey = config('services.aicheck.api_key');

        if (!$serviceUrl) {
            $job->update([
                'status' => AiCheckJob::STATUS_FAILED,
                'error_message' => 'AICHECK_API_URL не настроен в .env',
            ]);
            return;
        }

        if (!Storage::exists($job->stored_path)) {
            $job->update([
                'status' => AiCheckJob::STATUS_FAILED,
                'error_message' => 'Файл для анализа не найден',
            ]);
            return;
        }

        $fullPath = Storage::path($job->stored_path);
        $filename = basename($job->source_filename ?: $fullPath);

        try {
            $http = Http::timeout(600);

            if (!empty($apiKey)) {
                $http = $http->withHeaders([
                    'X-API-Key' => $apiKey,
                ]);
            }

            $response = $http
                ->attach('file', file_get_contents($fullPath), $filename)
                ->post($serviceUrl);

            if (!$response->successful()) {
                $msg = 'AiCheck сервис вернул ошибку: ' . $response->status() . ' ' . $response->body();
                $job->update([
                    'status' => AiCheckJob::STATUS_FAILED,
                    'error_message' => $msg,
                ]);
                return;
            }

            $payload = $response->json();
            $rawBody = $response->body();

            Log::info('AiCheck job: ответ нового сервиса', [
                'ai_check_job_id' => $job->id,
                'raw_body' => $rawBody,
                'payload' => $payload,
            ]);

            $assessment = is_array($payload ?? null) ? ($payload['assessment'] ?? null) : null;
            if (!is_array($assessment)) {
                // если формат неожиданный — сохраняем всё тело как текст
                $assessment = [
                    'overall_assessment' => is_string($rawBody) ? $rawBody : 'Не удалось получить заключение от сервиса проверки.',
                    'risk_level' => $payload['risk_level'] ?? 'MEDIUM',
                    'major_findings' => [],
                    'quality_scores' => [],
                    'common_error_patterns' => [],
                    'action_plan' => [],
                    'spot_check' => [],
                ];
            }

            $pdfs = is_array($payload ?? null) ? ($payload['pdfs'] ?? null) : null;

            $pdfLang = null;
            $pdfRuPath = null;
            $pdfKkPath = null;
            $pdfEnPath = null;

            if (is_array($pdfs)) {
                $baseDir = 'ai-check/results/' . $job->id;

                foreach (['ru', 'kk', 'en'] as $lang) {
                    if (!isset($pdfs[$lang]) || !is_string($pdfs[$lang])) {
                        continue;
                    }
                    $binary = base64_decode($pdfs[$lang], true);
                    if ($binary === false) {
                        continue;
                    }
                    $path = $baseDir . "/result_{$lang}.pdf";
                    Storage::put($path, $binary);

                    if ($lang === 'ru') {
                        $pdfRuPath = $path;
                    } elseif ($lang === 'kk') {
                        $pdfKkPath = $path;
                    } elseif ($lang === 'en') {
                        $pdfEnPath = $path;
                    }
                }

                $pdfLang = 'ru';
            }

            $job->update([
                'status' => AiCheckJob::STATUS_DONE,
                'result_json' => $assessment,
                'pdf_lang' => $pdfLang,
                'pdf_ru_path' => $pdfRuPath,
                'pdf_kk_path' => $pdfKkPath,
                'pdf_en_path' => $pdfEnPath,
                'error_message' => null,
            ]);
        } catch (\Throwable $e) {
            Log::error('AiCheck job: ошибка вызова сервиса', [
                'ai_check_job_id' => $job->id,
                'exception' => $e,
            ]);

            $job->update([
                'status' => AiCheckJob::STATUS_FAILED,
                'error_message' => 'Ошибка запроса к сервису AiCheck: ' . $e->getMessage(),
            ]);
        }
    }
}

