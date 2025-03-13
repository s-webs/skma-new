<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use App\Models\Advert;
use App\Models\ViewLog;
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

        if ($this->activeTheme) {
            return match ($this->activeTheme->code) {
                'winter' => view('pages.ads.winterIndex', compact('ads')),
                'summer' => view('pages.ads.summerIndex', compact('ads')),
                default => view('pages.ads.index', compact('ads')),
            };
        } else {
            return view('pages.ads.index', compact('ads'));
        }

    }

    public function show($slug)
    {
        if (app()->getLocale() === 'kz') {
            Carbon::setLocale('kk');
        }

        $locale = app()->getLocale();

        $localizedSlugColumn = 'slug_' . app()->getLocale();
        $item = Advert::query()->published()->where($localizedSlugColumn, $slug)->first();
        ViewLog::trackView($item, $locale);

        if ($item) {
            $item->formatted_date = Carbon::parse($item->created_at)->translatedFormat('j F Y');
            $item->formatted_time = Carbon::parse($item->created_at)->translatedFormat('H:i');
            $item->short_ru = Str::limit($item->title_ru, 30, '...');
            $item->short_kz = Str::limit($item->title_kz, 30, '...');
            $item->short_en = Str::limit($item->title_en, 30, '...');
        }

        if ($this->activeTheme) {
            return match ($this->activeTheme->code) {
                'winter' => view('pages.ads.winterShow', compact('item')),
                'summer' => view('pages.ads.summerShow', compact('item')),
                default => view('pages.ads.show', compact('item')),
            };
        } else {
            return view('pages.ads.show', compact('item'));
        }

    }
}
