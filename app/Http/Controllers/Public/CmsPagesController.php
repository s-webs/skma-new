<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use App\Models\CmsPage;
use App\Models\News;
use App\Models\ViewLog;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Str;

class CmsPagesController extends Controller
{
    public function show($slug)
    {
        if (app()->getLocale() === 'kz') {
            Carbon::setLocale('kk');
        }

        $locale = app()->getLocale();

        $localizedSlugColumn = 'slug_' . app()->getLocale();
        $item = CmsPage::query()->where($localizedSlugColumn, $slug)->firstOrFail();

        if ($item) {
            $item->formatted_date = Carbon::parse($item->created_at)->translatedFormat('j F Y');
            $item->formatted_time = Carbon::parse($item->created_at)->translatedFormat('H:i');
            $item->short_ru = Str::limit($item->name_ru, 30, '...');
            $item->short_kz = Str::limit($item->name_kz, 30, '...');
            $item->short_en = Str::limit($item->name_en, 30, '...');

            // Обработка файлов
            $files = json_decode($item->getProperty('files')) ?? [];
            $item->files = collect($files)->map(function ($file) {
                return [
                    'path' => dirname($file) . '/' . basename($file),
                    'name' => basename($file)
                ];
            })->toArray();
        }

        return view('pages.cmsPages.show', compact('item'));
    }
}
