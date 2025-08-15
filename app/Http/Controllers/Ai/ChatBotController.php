<?php

namespace App\Http\Controllers\Ai;

use App\Http\Controllers\Controller;
use App\Services\OpenAIService;
use Illuminate\Http\Request;

class ChatBotController extends Controller
{
    public function chat(Request $req, OpenAIService $ai)
    {
        $req->validate([
            'message' => 'required|string|max:2000',
            'locale' => 'nullable|in:ru,kz,en',
        ]);

        // 1) берём locale из запроса или сайтовой локали
        $locale = $req->input('locale', app()->getLocale()); // ru|kz|en

        try {
            $ans = $ai->answerWithRAGForLocale($locale, (string)$req->input('message'));
            return response()->json(['ok' => true, 'answer' => $ans['text']]);
        } catch (\Throwable $e) {
            return response()->json(['ok' => false, 'error' => 'AI error: ' . $e->getMessage()], 500);
        }
    }

    public function ingest(Request $req, OpenAIService $ai)
    {
        $req->validate([
            'file' => 'required|file|mimes:pdf,txt,doc,docx,md',
            'locale' => 'required|in:ru,kz,en',
        ]);

        try {
            $path = $req->file('file')->store('tmp_ingest');
            $abs = storage_path('app/' . $path);
            $file = $ai->uploadFileForLocale($req->string('locale'), $abs);
            return response()->json(['ok' => true, 'file_id' => $file['id']]);
        } catch (\Throwable $e) {
            return response()->json(['ok' => false, 'error' => $e->getMessage()], 500);
        }
    }
}
