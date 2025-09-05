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

        $query = \DB::table('news')
            ->select([
                'id',
                "title_$lang as title",
                "preview_$lang as preview",
                "slug_$lang as slug",
                "views_$lang as views",
                'author',
                'created_at'
            ])
            ->orderByDesc('id')
            ->paginate($perPage);

        return response()->json($query);
    }
}
