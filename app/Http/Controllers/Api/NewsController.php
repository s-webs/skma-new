<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\News\GetNewsRequest;
use App\Http\Resources\NewsResource;
use App\Models\Like;
use App\Models\News;
use App\Repositories\NewsRepository;
use DOMDocument;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;

class NewsController extends Controller
{
    public function getNews(GetNewsRequest $request, NewsRepository $repo)
    {
        $perPage = $request->perPage();
        $langForColumns = $request->langForColumns();
        $userId = optional($request->user())->id;

        $paginator = $repo->paginate($langForColumns, $perPage, $userId);

        // Вернёт JSON с data + meta/links пагинации
        return NewsResource::collection($paginator);
    }

    public function like(Request $request, News $news)
    {
        $user = $request->user();

        DB::transaction(function () use ($news, $user) {
            $exists = Like::where('news_id', $news->id)
                ->where('user_id', $user->id)
                ->lockForUpdate()
                ->exists();

            if (!$exists) {
                Like::create([
                    'news_id' => $news->id,
                    'user_id' => $user->id,
                ]);
            }
        });

        $count = Like::where('news_id', $news->id)->count();

        return response()->json([
            'news_id' => $news->id,
            'liked' => true,
            'likes_count' => $count,
        ], 200);
    }

    public function unlike(Request $request, News $news)
    {
        $user = $request->user();

        DB::transaction(function () use ($news, $user) {
            Like::where('news_id', $news->id)
                ->where('user_id', $user->id)
                ->lockForUpdate()
                ->delete(); // идемпотентно: если нет — просто 0 удалений
        });

        $count = Like::where('news_id', $news->id)->count();

        return response()->json([
            'news_id' => $news->id,
            'liked' => false,
            'likes_count' => $count,
        ], 200);
    }

}
