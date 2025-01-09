<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Symfony\Component\HttpFoundation\Response;

class SetLocale
{
    public function handle($request, Closure $next)
    {
        $locale = $request->route('locale');

        if (in_array($locale, ['en', 'ru', 'kz'])) {
            App::setLocale($locale);
        } else {
            abort(404);
        }

        return $next($request);
    }
}
