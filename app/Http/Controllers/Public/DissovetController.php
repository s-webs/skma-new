<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class DissovetController extends Controller
{
    public function index()
    {
        return view('pages.dis_sovet.index');
    }
}
