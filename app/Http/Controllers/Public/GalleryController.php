<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use App\Models\Gallery;
use Illuminate\Http\Request;

class GalleryController extends Controller
{
    public function index()
    {
        $images = Gallery::all();

        if ($this->activeTheme) {
            return match ($this->activeTheme->code) {
                'winter' => view('pages.gallery.winterIndex', compact('images')),
                'summer' => view('pages.gallery.summerIndex', compact('images')),
                'autumn' => view('pages.gallery.autumnIndex', compact('images')),
                default => view('pages.gallery.index', compact('images')),
            };
        } else {
            return view('pages.gallery.index', compact('images'));
        }
    }
}
