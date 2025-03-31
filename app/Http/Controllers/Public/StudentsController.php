<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use App\Models\ForStudent;
use App\Models\Service;
use Illuminate\Http\Request;

class StudentsController extends Controller
{
    public function index()
    {
        $services = Service::all();
        $information = ForStudent::query()->first();

        return view('pages.student.index', compact('services', 'information'));
    }
}
