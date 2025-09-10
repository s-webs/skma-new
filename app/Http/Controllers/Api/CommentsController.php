<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\CommentResource;
use App\Models\Comment;
use App\Models\News;
use Illuminate\Http\Request;

class CommentsController extends Controller
{
// GET /api/news/{news}/comments?page=1&per_page=20&lang=ru
    public function index(Request $request, News $news)
    {
        $perPage = (int)$request->query('per_page', 20);

        $comments = $news->comments()     // связь уже есть в модели News
        ->with('user:id,name')        // подтянем имя автора
        ->orderBy('created_at', 'desc')
            ->paginate($perPage);

        return CommentResource::collection($comments);
    }

    // POST /api/news/{news}/comments  { comment: "Текст" }
    public function store(Request $request, News $news)
    {
        $request->validate([
            'comment' => 'required|string|min:1|max:2000',
        ]);

        $user = $request->user(); // auth:sanctum

        $comment = Comment::create([
            'news_id' => $news->id,
            'user_id' => $user->id,
            'comment' => $request->string('comment'),
        ]);

        // вернуть созданный комментарий
        return new CommentResource($comment->load('user:id,name'));
    }

    // DELETE /api/comments/{comment}
    public function destroy(Request $request, Comment $comment)
    {
        $user = $request->user();
        if ($comment->user_id !== $user->id) {
            return response()->json(['message' => 'Forbidden'], 403);
        }
        $comment->delete();
        return response()->json(['status' => 'ok']);
    }
}
