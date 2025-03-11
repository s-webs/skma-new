<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use App\Models\Advert;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Str;

class AdsController extends Controller
{
    public function index()
    {
        if (app()->getLocale() === 'kz') {
            Carbon::setLocale('kk');
        }

        $ads = Advert::query()->where('is_published', '=', 1)->paginate(9)
            ->map(function ($item) {
                $item->formatted_date = Carbon::parse($item->created_at)->translatedFormat('j F Y');
                return $item;
            });

        return view('pages.ads.index', compact('ads'));
    }

    public function show($slug)
    {
        if (app()->getLocale() === 'kz') {
            Carbon::setLocale('kk');
        }

        $localizedSlugColumn = 'slug_' . app()->getLocale();
        $item = Advert::query()->published()->where($localizedSlugColumn, $slug)->first();

        if ($item) {
            $item->formatted_date = Carbon::parse($item->created_at)->translatedFormat('j F Y');
            $item->formatted_time = Carbon::parse($item->created_at)->translatedFormat('H:i');
            $item->short_ru = Str::limit($item->title_ru, 30, '...');
            $item->short_kz = Str::limit($item->title_kz, 30, '...');
            $item->short_en = Str::limit($item->title_en, 30, '...');
        }

        return view('pages.ads.show', compact('item'));

    }
}
