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
        return view('pages.awards.index', compact('awards'));
    }
}
