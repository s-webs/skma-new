<?php

namespace App\Services;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;

class OpenAIAssistantsService
{
    private Client $http;
    private string $assistantId;

    public function __construct()
    {
        $this->http = new Client([
            'base_uri' => rtrim(env('OPENAI_BASE', 'https://api.openai.com/v1'), '/') . '/',
            'timeout' => 60,
            'headers' => [
                'Authorization' => 'Bearer ' . env('OPENAI_API_KEY'),
                'OpenAI-Beta' => 'assistants=v2',  // v2
                'Content-Type' => 'application/json',
                'Accept' => 'application/json',
            ],
        ]);

        $this->assistantId = (string)env('OPENAI_ASSISTANT_ID');
    }

    /**
     * Задать вопрос ассистенту. Если передать $threadId — продолжит диалог.
     * Возвращает: ['thread_id' => string, 'text' => string]
     */
    public function ask(string $question, ?string $threadId = null): array
    {
        try {
            // 1) Thread
            if (!$threadId) {
                $raw = $this->http->post('threads', ['json' => (object)[]])->getBody()->getContents();
                $threadId = json_decode($raw, true)['id'] ?? null;
                if (!$threadId) throw new \RuntimeException('No thread id returned');
            }

            // 2) User message
            $this->http->post("threads/{$threadId}/messages", [
                'json' => [
                    'role' => 'user',
                    'content' => [['type' => 'text', 'text' => $question]],
                ],
            ]);

            // 3) Run
            $rawRun = $this->http->post("threads/{$threadId}/runs", [
                'json' => ['assistant_id' => $this->assistantId],
            ])->getBody()->getContents();

            $runId = json_decode($rawRun, true)['id'] ?? null;
            if (!$runId) throw new \RuntimeException('No run id returned');

            // 4) Poll до completed
            $deadline = microtime(true) + 60; // тайм-аут 60с
            do {
                usleep(300 * 1000);
                $raw = $this->http->get("threads/{$threadId}/runs/{$runId}")
                    ->getBody()->getContents();
                $status = json_decode($raw, true)['status'] ?? 'unknown';

                if (in_array($status, ['failed', 'cancelled', 'expired'], true)) {
                    throw new \RuntimeException("Run status: {$status}");
                }
            } while ($status !== 'completed' && microtime(true) < $deadline);

            // 5) Забираем последнее сообщение ассистента
            $rawMsgs = $this->http->get("threads/{$threadId}/messages", [
                'query' => ['limit' => 1, 'order' => 'desc'],
            ])->getBody()->getContents();

            $messages = json_decode($rawMsgs, true);
            $text = $this->extractTextFromMessage($messages['data'][0] ?? []);

            return ['thread_id' => $threadId, 'text' => $text];
        } catch (GuzzleException $e) {
            throw new \RuntimeException('OpenAI request failed: ' . $e->getMessage(), previous: $e);
        }
    }

    private function extractTextFromMessage(array $message): string
    {
        $out = '';
        foreach (($message['content'] ?? []) as $c) {
            if (($c['type'] ?? '') === 'text') {
                // в v2 текст лежит в ['text']['value']
                $out .= $c['text']['value'] ?? ($c['text'] ?? '');
            }
        }
        return trim($out);
    }
}
