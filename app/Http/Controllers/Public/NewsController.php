<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use App\Models\News;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Str;

class NewsController extends Controller
{

    public function index()
    {
        if (app()->getLocale() === 'kz') {
            Carbon::setLocale('kk');
        }

        $news = News::query()->published()->orderBy('created_at', 'desc')->paginate(9);

        $news->getCollection()->transform(function ($newsItem) {
            $newsItem->formatted_date = Carbon::parse($newsItem->created_at)->translatedFormat('j F Y');
            $newsItem->title_ru = Str::limit($newsItem->title_ru, 60, '...');
            $newsItem->title_kz = Str::limit($newsItem->title_kz, 60, '...');
            $newsItem->title_en = Str::limit($newsItem->title_en, 60, '...');
            return $newsItem;
        });


        return view('pages.news.index', compact('news'));
    }

    public function show($slug)
    {
        if (app()->getLocale() === 'kz') {
            Carbon::setLocale('kk');
        }

        $localizedSlugColumn = 'slug_' . app()->getLocale();
        $item = News::query()->published()->where($localizedSlugColumn, $slug)->first();

        if ($item) {
            $item->formatted_date = Carbon::parse($item->created_at)->translatedFormat('j F Y');
            $item->formatted_time = Carbon::parse($item->created_at)->translatedFormat('H:i'); // Добавляем форматированное время
        }

        return view('pages.news.show', compact('item'));
    }
}
