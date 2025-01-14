<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use App\Models\Counter;
use App\Models\Service;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index($locale)
    {
        if (!in_array($locale, ['en', 'ru', 'kz'])) {
            abort(404);
        }

        app()->setLocale($locale);

        $counters = Counter::all();
        $services = Service::query()->where('active', '=', 1)->orderBy('order')->get();


        return view('pages.public.home.index', compact('counters', 'services'));
    }
}
