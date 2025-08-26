<?php

namespace App\Http\Controllers\Ai;

use App\Http\Controllers\Controller;
use App\Services\N8nAiService;
use Illuminate\Http\Request;

class ChatBotController extends Controller
{
    public function chat(Request $req, N8nAiService $ai)
    {
        $req->validate([
            'message' => 'required|string|max:2000',
            'locale' => 'nullable|in:ru,kz,en',
            'thread_id' => 'nullable|string',
        ]);

        try {
            $ans = $ai->ask(
                $req->input('message'),
                $req->input('thread_id') ?: uniqid('sess_') // если нет thread_id, создаём новый
            );

            return response()->json([
                'ok' => true,
                'answer' => $ans['text'],
                'thread_id' => $ans['thread_id'],
            ]);
        } catch (\Throwable $e) {
            return response()->json([
                'ok' => false,
                'error' => 'AI error: ' . $e->getMessage(),
            ], 500);
        }
    }
}
