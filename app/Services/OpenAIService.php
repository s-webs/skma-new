<?php

namespace App\Services;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;
use Illuminate\Support\Str;

class OpenAIService
{
    private Client $http;
    private string $apiKey;
    private string $base;
    private string $model;

    private ?string $vsRU;
    private ?string $vsKZ; // для locale=kz
    private ?string $vsEN;
    private ?string $vsCOMMON;

    public function __construct()
    {
        $this->apiKey = (string)config('services.openai.key', env('OPENAI_API_KEY'));
        $this->base = rtrim((string)env('OPENAI_BASE', 'https://api.openai.com/v1'), '/');
        $this->model = (string)env('OPENAI_MODEL', 'gpt-5-nano');

        $this->vsRU = env('OPENAI_VECTOR_STORE_ID_RU') ?: null;
        $this->vsKZ = env('OPENAI_VECTOR_STORE_ID_KZ') ?: null;
        $this->vsEN = env('OPENAI_VECTOR_STORE_ID_EN') ?: null;
        $this->vsCOMMON = env('OPENAI_VECTOR_STORE_ID_COMMON') ?: null;

        $this->http = new Client([
            'base_uri' => $this->base . '/',
            'timeout' => 120,
            'headers' => [
                'Authorization' => 'Bearer ' . $this->apiKey,
                'Accept' => 'application/json',
                'Accept-Charset' => 'utf-8',
            ],
        ]);
    }

    /* ---------- Управление Vector Store ---------- */

    /** Создать новый Vector Store и вернуть его id */
    public function createVectorStore(string $namePrefix = 'vs_lang_'): string
    {
        $name = $namePrefix . Str::uuid()->toString();
        $res = $this->http->post('vector_stores', [
            'headers' => ['Content-Type' => 'application/json; charset=utf-8'],
            'json' => ['name' => $name, 'metadata' => ['app' => 'skma-chatbot']],
        ])->getBody()->getContents();

        $data = $this->safeJsonDecode($res);
        if (empty($data['id'])) {
            throw new \RuntimeException('Cannot create vector store: missing id');
        }
        return (string)$data['id'];
    }

    /** Ингест файла в заданный VS */
    public function uploadFileToVectorStore(string $vsId, string $absolutePath): array
    {
        if (!is_file($absolutePath)) {
            throw new \InvalidArgumentException("File not found: {$absolutePath}");
        }

        // 1) upload в Files
        $fileRes = $this->http->post('files', [
            'multipart' => [
                ['name' => 'purpose', 'contents' => 'assistants'],
                ['name' => 'file', 'contents' => fopen($absolutePath, 'r'), 'filename' => basename($absolutePath)],
            ],
        ])->getBody()->getContents();

        $file = $this->safeJsonDecode($fileRes);
        if (empty($file['id'])) {
            throw new \RuntimeException('Upload failed: file id is empty');
        }

        // 2) привязка к VS
        $this->http->post("vector_stores/{$vsId}/files", [
            'headers' => ['Content-Type' => 'application/json; charset=utf-8'],
            'json' => ['file_id' => $file['id']],
        ]);

        return $file;
    }

    /** Ингест в VS по locale (ru|kz|en) */
    public function uploadFileForLocale(string $locale, string $absolutePath): array
    {
        $vsIds = $this->getVectorStoreIdsForLocale($locale);
        if (empty($vsIds)) {
            throw new \RuntimeException("No vector store configured for locale={$locale}");
        }
        return $this->uploadFileToVectorStore($vsIds[0], $absolutePath); // первый — профильный
    }

    /** Диагностика: список файлов в VS */
    public function listVectorStoreFiles(string $vsId): array
    {
        $res = $this->http->get("vector_stores/{$vsId}/files")->getBody()->getContents();
        return $this->safeJsonDecode($res);
    }

    /* ---------- Ответы (RAG) ---------- */

    /** Нормализация locale -> целевой язык промпта (kk/ru/en), и флаг казахского */
    private function normalizeLangFromLocale(string $locale): array
    {
        $lc = strtolower(trim($locale));
        return match ($lc) {
            'kz', 'kk' => ['kk', true],   // для промпта используем kk, но locale принимаем kz
            'en' => ['en', false],
            default => ['ru', false],
        };
    }

    /** Массив VS для заданного locale (+ общий, если есть) */
    private function getVectorStoreIdsForLocale(string $locale): array
    {
        $ids = [];
        $lc = strtolower(trim($locale));
        if ($lc === 'ru' && $this->vsRU) $ids[] = $this->vsRU;
        if ($lc === 'kz' && $this->vsKZ) $ids[] = $this->vsKZ;
        if ($lc === 'en' && $this->vsEN) $ids[] = $this->vsEN;
        if ($this->vsCOMMON) $ids[] = $this->vsCOMMON;
        return $ids;
    }

    /**
     * Основной ответ с учётом locale (ru|kz|en) и соответствующих VS.
     * Возвращает: ['text' => string]
     */
    public function answerWithRAGForLocale(string $locale, string $userText): array
    {
        [$lang, $isKazakh] = $this->normalizeLangFromLocale($locale);
        $vsIds = $this->getVectorStoreIdsForLocale($locale);
        if (empty($vsIds)) {
            // если не настроены языковые VS — можно выбросить исключение или вернуть мягкий ответ
            return ['text' => $this->notFoundMessage($lang)];
        }

        $system = <<<SYS
You are a multilingual university helpdesk assistant.
Target language: {$lang}.

STRICT RULES:
- Respond STRICTLY in the target language ({$lang}) only. Do not mix languages.
- Use ONLY facts grounded in file_search results from the provided vector store(s).
- If no relevant facts are found via file_search, say you don't know in {$lang} and suggest where to ask (dean's office, official website). Do NOT guess.
- Do NOT include sources or file names in the answer.
- Keep answers concise. Use bullet points for steps.
- For Kazakh, use Cyrillic script (no transliteration).
SYS;

        $kwHint = "First, synthesize 3–6 keyword queries in {$lang} from the user's question (preserve department/proper names). Then call file_search.";

        $payload = [
            "model" => $this->model, // gpt-5-nano
            "input" => [
                ["role" => "system", "content" => $system],
                ["role" => "system", "content" => $kwHint],
                ["role" => "user", "content" => (string)$userText],
            ],
            "tools" => [[
                "type" => "file_search",
                "vector_store_ids" => $vsIds,
                "max_num_results" => 20,
            ]],
            "tool_choice" => "auto", // gpt-5-nano поддерживает только auto
        ];

        try {
            $resRaw = $this->http->post('responses', [
                'headers' => ['Content-Type' => 'application/json; charset=utf-8'],
                'json' => $payload,
            ])->getBody()->getContents();
        } catch (GuzzleException $e) {
            throw new \RuntimeException('OpenAI request failed: ' . $e->getMessage(), previous: $e);
        }

        if (config('app.debug')) \Log::debug('OpenAI RAG raw: ' . $resRaw);
        $res = $this->safeJsonDecode($resRaw);
        $text = $this->extractText($res);

        // Если инструмент не вызывался или текста нет — честно «не знаю»
        if (!$this->hasFileSearchCall($res) || $text === '') {
            $text = $this->notFoundMessage($lang);
            return ['text' => $text];
        }

        // Вырезаем любые "Sources:" если модель вдруг их добавила
        $text = $this->stripSourcesFromText($text);

        // Если модель сорвалась на другой язык — сделаем внутренний перевод
        $ansLang = $this->detectLangFromText($text);
        if ($ansLang !== $lang) {
            $text = $this->translateToLang($text, $lang);
        }

        // Доп. страховки
        if ($lang === 'ru' && preg_match('/[a-z]/i', $text) && !preg_match('/\p{Cyrillic}/u', $text)) {
            $text = "Извините, повторите вопрос на русском (или добавьте источник на русском).";
        }
        if ($lang === 'kk' && preg_match('/\p{Cyrillic}/u', $text) && !preg_match('/[әіңғқүұөһ]/u', $text)) {
            $text = "Кешіріңіз, сұрақты қазақ тілінде нақтылап беріңіз немесе қазақ тіліндегі дерек жүктеңіз.";
        }

        return ['text' => $text];
    }

    /* ---------- Вспомогательные ---------- */

    private function detectLangFromText(string $text): string
    {
        $t = mb_strtolower($text, 'UTF-8');
        if (preg_match('/[әіңғқүұөһ]/u', $t)) return 'kk';
        if (preg_match('/\p{Cyrillic}/u', $t)) return 'ru';
        if (preg_match('/[a-z]/i', $t)) return 'en';
        return 'ru';
    }

    private function translateToLang(string $text, string $lang): string
    {
        $sys = "You are a professional translator. Translate the user's message into {$lang}. Keep meaning, tone and named entities unchanged. For Kazakh, use Cyrillic script.";
        $payload = [
            "model" => $this->model,
            "input" => [
                ["role" => "system", "content" => $sys],
                ["role" => "user", "content" => $text],
            ],
        ];
        try {
            $raw = $this->http->post('responses', [
                'headers' => ['Content-Type' => 'application/json; charset=utf-8'],
                'json' => $payload,
            ])->getBody()->getContents();
            $res = $this->safeJsonDecode($raw);
            $out = $this->extractText($res);
            return $out !== '' ? $out : $text;
        } catch (\Throwable $e) {
            return $text;
        }
    }

    private function hasFileSearchCall(array $res): bool
    {
        if (empty($res['output']) || !is_array($res['output'])) return false;
        foreach ($res['output'] as $b) {
            if (($b['type'] ?? '') === 'file_search_call') return true;
        }
        return false;
    }

    private function extractText(array $res): string
    {
        if (isset($res['output_text']) && is_string($res['output_text'])) {
            return trim($res['output_text']);
        }
        $text = '';
        if (!empty($res['output']) && is_array($res['output'])) {
            foreach ($res['output'] as $block) {
                if (($block['type'] ?? '') === 'message' && !empty($block['content']) && is_array($block['content'])) {
                    foreach ($block['content'] as $c) {
                        if (isset($c['text']) && is_string($c['text'])) $text .= $c['text'];
                    }
                }
            }
        }
        if ($text !== '') return trim($text);
        if (isset($res['choices'][0]['message']['content'])) {
            return (string)$res['choices'][0]['message']['content'];
        }
        return '';
    }

    private function stripSourcesFromText(string $text): string
    {
        return rtrim(preg_replace('/(?:\r?\n){0,2}Sources:\s*.*\z/su', '', (string)$text));
    }

    private function notFoundMessage(string $lang): string
    {
        return match ($lang) {
            'kk' => "Кешіріңіз, бұл сұраққа қатысты дерек жүктелген файлдарда табылмады. Дәлдеп сұраңыз немесе сәйкес PDF қосыңыз.",
            'en' => "Sorry, I couldn't find this in the uploaded sources. Please refine your question or add a relevant PDF.",
            default => "Извините, не нашёл данных в загруженных источниках. Уточните вопрос или добавьте соответствующий PDF.",
        };
    }

    private function safeJsonDecode(string $json): array
    {
        $data = json_decode($json, true);
        if (json_last_error() !== JSON_ERROR_NONE) {
            throw new \RuntimeException('JSON decode error: ' . json_last_error_msg());
        }
        return is_array($data) ? $data : [];
    }
}
