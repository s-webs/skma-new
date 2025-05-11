<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Log;
use Symfony\Component\HttpFoundation\Response;

class SetLocale
{
    public function handle($request, Closure $next)
    {
        $locale = $request->segment(1);

        Log::info("Locale from URL: " . $locale); // Логируем текущую локаль из URL

        if (in_array($locale, ['en', 'ru', 'kz'])) {
            App::setLocale($locale);
        } else {
            App::setLocale('kz'); // Устанавливаем по умолчанию 'kz'
        }

        return $next($request);
    }
}
