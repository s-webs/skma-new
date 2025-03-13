<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use App\Models\Award;
use Illuminate\Http\Request;

class AwardsController extends Controller
{
    public function index()
    {
        $awards = Award::all();

        if ($this->activeTheme) {
            return match ($this->activeTheme->code) {
                'winter' => view('pages.awards.winterIndex', compact('awards')),
                'summer' => view('pages.awards.summerIndex', compact('awards')),
                'autumn' => view('pages.awards.autumnIndex', compact('awards')),
                default => view('pages.awards.index', compact('awards')),
            };
        } else {
            return view('pages.awards.index', compact('awards'));
        }
    }
}
