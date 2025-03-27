<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use App\Models\Advert;
use App\Models\Announce;
use App\Models\Award;
use App\Models\Counter;
use App\Models\Feedback;
use App\Models\Gallery;
use App\Models\News;
use App\Models\OrgNode;
use App\Models\Partner;
use App\Models\Service;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Str;

class HomeController extends Controller
{
    public function index()
    {

        if (app()->getLocale() === 'kz') {
            Carbon::setLocale('kk');
        }

        $counters = Counter::take(4)->get();
        $services = Service::query()->where('active', '=', 1)->orderBy('order')->get();
        $announcements = Announce::query()
            ->where('is_published', '=', 1)
            ->orderBy('created_at', 'desc')
            ->get()
            ->map(function ($announcement) {
                return [
                    'title' => $announcement->getProperty('title'),
                    'description' => $announcement->getProperty('description'),
                    'link' => $announcement->getProperty('link'),
                    'image' => $announcement->getProperty('image'),
                ];
            });
        $latestArticle = News::query()
            ->where('published', '=', 1)
            ->orderBy('created_at', 'desc')
            ->first(); // Получаем самую свежую новость

        if ($latestArticle) {
            $latestArticle->formatted_date = Carbon::parse($latestArticle->created_at)->translatedFormat('j F Y');
        }

        $news = News::query()
            ->where('published', '=', 1)
            ->orderBy('created_at', 'desc')
            ->when($latestArticle, function ($query) use ($latestArticle) {
                $query->where('id', '!=', $latestArticle->id);
            })
            ->take(5)
            ->get()
            ->map(function ($newsItem) {
                $newsItem->formatted_date = Carbon::parse($newsItem->created_at)->translatedFormat('j F Y');
                $newsItem->title_ru = Str::limit($newsItem->title_ru, 60, '...');
                $newsItem->title_kz = Str::limit($newsItem->title_kz, 60, '...');
                $newsItem->title_en = Str::limit($newsItem->title_en, 60, '...');
                return $newsItem;
            });

        $feedbacks = Feedback::query()->where('language', '=', app()->getLocale())->take(10)->get();

        $adverts = Advert::query()->where('is_published', '=', 1)->orderBy('created_at', 'desc')->take(3)->get()
            ->map(function ($item) {
                $item->formatted_date = Carbon::parse($item->created_at)->translatedFormat('j F Y');
                return $item;
            });

        $gallery = Gallery::all()->take('5');

        $services = Service::all()->take('5');

        $awards = Award::query()->where('is_published', '=', 1)->take('4')->get();
        $partners = Partner::all();

        return view('pages.home.index', compact('counters', 'services', 'news', 'latestArticle', 'announcements', 'feedbacks', 'adverts', 'gallery', 'services', 'awards', 'partners')); // Или другой шаблон по умолчанию
    }
}
