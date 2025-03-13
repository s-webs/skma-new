<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use App\Models\Division;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Str;

class DivisionsController extends Controller
{
    public function index()
    {
        $divisions = Division::whereNull('parent_id')->with('children')->get();

        if ($this->activeTheme) {
            return match ($this->activeTheme->code) {
                'winter' => view('pages.divisions.winterIndex', compact('divisions')),
                default => view('pages.divisions.index', compact('divisions')),
            };
        } else {
            return view('pages.divisions.index', compact('divisions'));
        }
    }

    public function show($slug)
    {
        $localizedSlugColumn = 'slug_' . app()->getLocale();
        $item = Division::query()->where($localizedSlugColumn, $slug)->firstOrFail();

        $item->documents_ru = $item->transformDocuments($item->documents_ru);
        $item->documents_kz = $item->transformDocuments($item->documents_kz);
        $item->documents_en = $item->transformDocuments($item->documents_en);

        $parent = $item->parent;
        $children = $item->children;

        if ($this->activeTheme) {
            return match ($this->activeTheme->code) {
                'winter' => view('pages.divisions.winterShow', compact('item', 'parent', 'children')),
                default => view('pages.divisions.show', compact('item', 'parent', 'children')),
            };
        } else {
            return view('pages.divisions.show', compact('item', 'parent', 'children'));
        }
    }
}
