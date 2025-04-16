<?php

namespace App\Http\Middleware;

use App\Models\ViewLog;
use App\Models\Visitor;
use Closure;
use GeoIp2\Database\Reader;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;
use Symfony\Component\HttpFoundation\Response;

class TrackVisitor
{
    public function handle(Request $request, Closure $next): Response
    {
        $cookieName = 'site_visitor_id';
        $ip = $request->ip();

        if (!$request->hasCookie($cookieName)) {
            $cookieValue = Str::uuid();
            Cookie::queue($cookieName, $cookieValue, 60 * 24);
        } else {
            $cookieValue = $request->cookie($cookieName);
        }

        $visitor = Visitor::query()->firstOrCreate([
            'cookie_id' => $cookieValue,
        ], [
            'ip_address' => $ip,
        ]);

        $visitor->update(['last_activity' => Carbon::now()]);

        if (!$visitor->country_code) {
            try {
                $reader = new Reader(public_path('assets/GeoLite2-Country.mmdb'));
                $record = $reader->country($ip);
                $visitor->country_code = $record->country->isoCode;
                $visitor->save();
            } catch (\Exception $e) {
                Log::error('GeoIP Error: ' . $e->getMessage());
            }
        }

        return $next($request);
    }
}
