<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Validation\ValidationException;
use Symfony\Component\HttpFoundation\Response;

class FileManagerRateLimit
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next, string $type = 'general'): Response
    {
        $config = config('filemanager.rate_limit', []);
        $limit = $config[$type] ?? $config['general'] ?? 60;
        
        // Для загрузки файлов используем более длинное окно (2 минуты) для большей гибкости
        $decayMinutes = $type === 'upload' ? 2 : 1;
        
        $key = $this->resolveRequestSignature($request, $type);

        if (RateLimiter::tooManyAttempts($key, $limit)) {
            $seconds = RateLimiter::availableIn($key);
            
            throw ValidationException::withMessages([
                'rate_limit' => "Слишком много запросов. Попробуйте снова через {$seconds} секунд.",
            ])->status(429);
        }

        RateLimiter::hit($key, $decayMinutes * 60); // 1-2 minute window

        return $next($request);
    }

    /**
     * Resolve request signature for rate limiting
     */
    protected function resolveRequestSignature(Request $request, string $type): string
    {
        $user = $request->user('moonshine');
        $identifier = $user ? $user->id : $request->ip();
        
        return 'filemanager:' . $type . ':' . $identifier;
    }
}
