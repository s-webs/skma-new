<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use App\Models\Counter;
use App\Models\ForApplicant;
use App\Models\Service;
use Illuminate\Http\Request;

class ApplicantController extends Controller
{
    public function index()
    {
        $counters = Counter::all();
        $applicant = ForApplicant::query()->firstOrFail();

        return view('pages.applicant.index', compact('counters', 'applicant'));
    }
}
