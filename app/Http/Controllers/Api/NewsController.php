<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\News;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class NewsController extends Controller
{
    public function getNews(Request $request)
    {
        $lang = $request->get('lang', 'ru');
        $perPage = $request->get('per_page', 10);

        $query = News::select([
            'id',
            "title_$lang as title",
            "preview_$lang as preview",
            "text_$lang as text",
            "slug_$lang as slug",
            "views_$lang as views",
            'author',
            'created_at'
        ])
            ->withCount(['likes', 'comments']) // 🔥 количество
            ->with(['likes', 'comments'])     // 🔥 сами записи (если нужны)
            ->orderByDesc('id')
            ->paginate($perPage);

        return response()->json($query);
    }
}
