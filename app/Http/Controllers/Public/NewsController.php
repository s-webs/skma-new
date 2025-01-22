<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use App\Models\News;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class NewsController extends Controller
{

    public function index()
    {
        $news = News::query()->published()->orderBy('created_at', 'desc')
            ->paginate(9)
            ->map(function ($newsItem) {
                // Обрезаем заголовки
                $newsItem->title_ru = Str::limit($newsItem->title_ru, 60, '...');
                $newsItem->title_kz = Str::limit($newsItem->title_kz, 60, '...');
                $newsItem->title_en = Str::limit($newsItem->title_en, 60, '...');
                return $newsItem;
            });

        return view('pages.news.index', compact('news'));
    }

    public function show($slug)
    {
        $localizedSlugColumn = 'slug_' . app()->getLocale();
        $item = News::query()->published()->where($localizedSlugColumn, $slug)->first();

        return view('pages.news.show', compact('item'));
    }
}
