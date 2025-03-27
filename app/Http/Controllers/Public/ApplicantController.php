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

        return view('pages.applicant.index', compact('counters'));
    }
}
