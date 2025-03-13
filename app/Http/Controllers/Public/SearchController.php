<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use App\Models\Advert;
use App\Models\Department;
use App\Models\Division;
use App\Models\News;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class SearchController extends Controller
{
    public function index(Request $request)
    {
        $query = $request->input('query');

        if (!$query) {
            return view('pages.search.index', [
                'advertResults' => [],
                'newsResults' => [],
                'divisionsResults' => [],
                'departmentsResults' => [],
                'query' => $query,
            ]);
        }

        $locale = app()->getLocale();

        // Поиск в Advert
        $advertResults = Advert::where('title_' . $locale, 'LIKE', "%{$query}%")
            ->orWhere('description_ru', 'LIKE', "%{$query}%")
            ->orWhere('description_kz', 'LIKE', "%{$query}%")
            ->orWhere('description_en', 'LIKE', "%{$query}%")
            ->get();

        // Поиск в News
        $newsResults = News::where('title_' . $locale, 'LIKE', "%{$query}%")
            ->orWhere('text_ru', 'LIKE', "%{$query}%")
            ->orWhere('text_kz', 'LIKE', "%{$query}%")
            ->orWhere('text_en', 'LIKE', "%{$query}%")
            ->orderBy('created_at', 'desc')
            ->get();

        // Поиск в Divisions
        $divisionsResults = Division::where('name_' . $locale, 'LIKE', "%{$query}%")
            ->orWhere('description_ru', 'LIKE', "%{$query}%")
            ->orWhere('description_kz', 'LIKE', "%{$query}%")
            ->orWhere('description_en', 'LIKE', "%{$query}%")
            ->get();

        // Поиск в Departments
        $departmentsResults = Department::where('name_ru', 'LIKE', "%{$query}%")
            ->orWhere('name_kz', 'LIKE', "%{$query}%")
            ->orWhere('name_en', 'LIKE', "%{$query}%")
            ->orWhere('description_ru', 'LIKE', "%{$query}%")
            ->orWhere('description_kz', 'LIKE', "%{$query}%")
            ->orWhere('description_en', 'LIKE', "%{$query}%")
            ->get();

        if ($this->activeTheme) {
            return match ($this->activeTheme->code) {
                'winter' => view('pages.search.winterIndex', [
                    'advertResults' => $advertResults,
                    'newsResults' => $newsResults,
                    'divisionsResults' => $divisionsResults,
                    'departmentsResults' => $departmentsResults,
                    'query' => $query,
                ]),
                default => view('pages.search.index', [
                    'advertResults' => $advertResults,
                    'newsResults' => $newsResults,
                    'divisionsResults' => $divisionsResults,
                    'departmentsResults' => $departmentsResults,
                    'query' => $query,
                ]),
            };
        } else {
            return view('pages.search.index', [
                'advertResults' => $advertResults,
                'newsResults' => $newsResults,
                'divisionsResults' => $divisionsResults,
                'departmentsResults' => $departmentsResults,
                'query' => $query,
            ]);
        }

    }
}
