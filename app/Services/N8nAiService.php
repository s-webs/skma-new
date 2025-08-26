<?php

namespace App\Services;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;

class N8nAiService
{
    private Client $http;
    private string $endpoint;

    public function __construct()
    {
        $this->http = new Client([
            'timeout' => 30,
            'headers' => [
                'Content-Type' => 'application/json',
                'Accept' => 'application/json',
            ],
        ]);

        // Адрес твоего n8n webhook (production URL!)
        $this->endpoint = rtrim(env('N8N_AI_URL', 'http://10.10.101.54:5678/webhook/assistant/ru'), '/');
//        $this->endpoint = rtrim(env('N8N_AI_URL', 'http://10.10.101.54:5678/webhook/assistant/en'), '/');
//        $this->endpoint = rtrim(env('N8N_AI_URL', 'http://10.10.101.54:5678/webhook/assistant/kz'), '/');
//        $this->endpoint = rtrim(env('N8N_AI_URL', 'http://10.10.101.54:5678/webhook/a9e0d3b4-dd23-4bea-b4d5-2d9ff7b1393b'), '/');
    }

    /**
     * Отправить вопрос в n8n агент
     */
    public function ask(string $question, string $sessionId = 'default'): array
    {
        try {
            $res = $this->http->post($this->endpoint, [
                'json' => [
                    'question' => $question,
                    'sessionId' => $sessionId,
                ],
            ]);

            $data = json_decode($res->getBody()->getContents(), true);

            return [
                'text' => $data[0]['output'] ?? 'Error',
                'thread_id' => $sessionId,
            ];
        } catch (GuzzleException $e) {
            throw new \RuntimeException('n8n request failed: ' . $e->getMessage(), previous: $e);
        }
    }

}
