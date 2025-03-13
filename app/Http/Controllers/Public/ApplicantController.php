<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use App\Models\Counter;
use Illuminate\Http\Request;

class ApplicantController extends Controller
{
    public function index()
    {
        $counters = Counter::all();

        if ($this->activeTheme) {
            return match ($this->activeTheme->code) {
                'winter' => view('pages.applicant.winterIndex', compact('counters')),
                'spring' => view('pages.applicant.springIndex', compact('counters')),
                'summer' => view('pages.applicant.summerIndex', compact('counters')),
                default => view('pages.applicant.index', compact('counters')),
            };
        } else {
            return view('pages.applicant.index', compact('counters'));
        }
    }
}
