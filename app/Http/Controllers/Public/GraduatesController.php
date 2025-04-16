<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use App\Models\Graduate;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Cache;

class GraduatesController extends Controller
{

    public function index()
    {
        $locale = app()->getLocale();
        $years = Graduate::query()->select('year')->distinct()->pluck('year');
        $faculties = Graduate::query()->select('faculty_' . $locale)->distinct()->pluck('faculty_' . $locale);

        return view('pages.graduates.index', compact('years', 'faculties'));
    }

    public function search(Request $request)
    {
        $locale = $request->input('locale', app()->getLocale());

        $query = Graduate::query();
        if ($request->filled('yearFrom')) {
            $query->where('year', '>=', $request->yearFrom);
        }
        if ($request->filled('yearTo')) {
            $query->where('year', '<=', $request->yearTo);
        }
        if ($request->filled('faculty')) {
            $query->where('faculty_' . $locale, $request->faculty);
        }
        if ($locale !== 'en' && $request->filled('name')) {
            $query->where('name', 'like', '%' . $request->name . '%');
        }
        if ($locale === 'en' && $request->filled('name')) {
            $query->where('name_latin', 'like', '%' . $request->name . '%');
        }

        $perPage = 9;
        $results = $query->paginate($perPage);

        return response()->json($results);
    }

}
