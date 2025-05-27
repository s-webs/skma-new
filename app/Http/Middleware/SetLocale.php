<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\URL;
use Symfony\Component\HttpFoundation\Response;

class SetLocale
{
    public function handle($request, Closure $next)
    {
        $locales = config('app.locales');
        $locale = $request->route('locale') ?: session('locale', config('app.fallback_locale'));

        if (!in_array($locale, $locales)) {
            $locale = config('app.fallback_locale');
        }

        app()->setLocale($locale);
        session()->put('locale', $locale);

        // Устанавливаем значения по умолчанию для URL
        URL::defaults(['locale' => $locale]);

        return $next($request);
    }
}
