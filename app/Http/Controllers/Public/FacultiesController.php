<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use App\Models\Department;
use App\Models\Faculty;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

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

        $lang = app()->getLocale();

        if ($item->umkd) {
            $umkd_files = scanDirectory($item->umkd, 'uploads', skipTopLevels: 1, maxDepth: 3);

            $item->umkd_files = $umkd_files;
        }

        if ($item->portfolio) {
            $portfolio_files = scanDirectory($item->portfolio, 'uploads', skipTopLevels: 1, maxDepth: 3);

            $item->portfolio_files = $portfolio_files;
        }

        if ($item->staff) {
            $item->staff = array_map(function ($member) use ($lang) {
                return [
                    'photo' => $member['photo'],
                    'name' => $member["name_{$lang}"] ?? '',
                    'position' => $member["position_{$lang}"] ?? '',
                    'email' => $member["email"] ?? '',
                    'phone' => $member["phone"] ?? '',
                ];
            }, $item->staff);
        }

        $parent = $item->parent;
        $children = $item->children;

        return view('pages.faculties.show', compact('item', 'parent', 'children'));
    }
}
