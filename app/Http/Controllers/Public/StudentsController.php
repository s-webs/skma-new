<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use App\Models\Service;
use Illuminate\Http\Request;

class StudentsController extends Controller
{
    public function index()
    {
        $services = Service::all();

        return view('pages.student.index', compact('services'));
    }
}
