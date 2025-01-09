<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use App\Models\Counter;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index($locale)
    {
        if (!in_array($locale, ['en', 'ru', 'kz'])) {
            abort(404); // Если язык не поддерживается
        }

        app()->setLocale($locale); // Устанавливаем язык
        $counters = Counter::all();
        return view('pages.public.home.index', compact('counters'));
    }
}
