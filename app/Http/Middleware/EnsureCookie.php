<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Str;
use Symfony\Component\HttpFoundation\Response;

class EnsureCookie
{
    /**
     * Handle an incoming request.
     *
     * @param \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response) $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $cookieName = 'site_visitor_id';

        if (!$request->hasCookie($cookieName)) {
            $cookieValue = Str::uuid();
            Cookie::queue($cookieName, $cookieValue, (60 * 24) * 7);
        }

        return $next($request);
    }
}
