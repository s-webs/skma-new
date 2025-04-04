<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use App\Models\Department;
use App\Models\Faculty;
use Illuminate\Http\Request;

class FacultiesController extends Controller
{
    public function index()
    {
        $faculties = Faculty::query()->with('children')->get();

        return view('pages.faculties.index', compact('faculties'));
    }

    public function show($slug)
    {
        $localizedSlugColumn = 'slug_' . app()->getLocale();

        $item = Faculty::query()->where($localizedSlugColumn, $slug)->firstOr(function () use ($localizedSlugColumn, $slug) {
            return Department::query()->where($localizedSlugColumn, $slug)->firstOrFail();
        });

        $item->documents_ru = $item->transformDocuments($item->documents_ru);
        $item->documents_kz = $item->transformDocuments($item->documents_kz);
        $item->documents_en = $item->transformDocuments($item->documents_en);

        $parent = $item->parent;
        $children = $item->children;

        $item->umkd = $item->umkd->map(function ($umkd) {
            $languageKey = 'type_' . app()->getLocale();

            $umkd = [
                'type' => $umkd[$languageKey],
                'files' => $umkd['files'],
            ];

            return $umkd;
        });

        dd($item->umkd);

        return view('pages.faculties.show', compact('item', 'parent', 'children'));
    }
}
