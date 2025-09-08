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

        $paginator = News::select([
            'id',
            "title_$lang as title",
            "preview_$lang as preview",
            \DB::raw("text_$lang as text"), // берём как есть
            "slug_$lang as slug",
            "views_$lang as views",
            'author',
            'created_at',
        ])
            ->withCount(['likes', 'comments'])
            ->orderByDesc('id')
            ->paginate($perPage);

        // Чистим теги у каждого элемента
        $paginator->getCollection()->transform(function ($item) {
            $clean = $item->text;

            // опционально: вырезать полностью содержимое <script>/<style>
            $clean = preg_replace('#<(script|style)\b[^<]*(?:(?!</\1>)<[^<]*)*</\1>#si', '', $clean);

            $clean = strip_tags($clean);                                   // убрать теги
            $clean = html_entity_decode($clean, ENT_QUOTES | ENT_HTML5);   // Декодировать &nbsp; и т.п. (по желанию)
            $clean = trim(preg_replace('/\s+/u', ' ', $clean));            // нормализовать пробелы

            $item->text = $clean;
            return $item;
        });

        return response()->json($paginator);
    }

}
