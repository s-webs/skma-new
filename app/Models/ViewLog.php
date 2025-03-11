<?php

namespace App\Models;

use GeoIp2\Database\Reader;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Request;

class ViewLog extends Model
{
    protected $fillable = [
        'ip_address',
        'country_code',
        'cookie_id',
        'viewable_type',
        'viewable_id',
        'locale',
    ];

    public static function trackView($viewable, $locale): void
    {
        $ip = Request::ip();
        $cookieId = Request::cookie('site_visitor_id');

        $viewLog = self::firstOrCreate([
            'cookie_id' => $cookieId,
            'viewable_id' => $viewable->id,
            'viewable_type' => get_class($viewable),
            'locale' => $locale,
        ], [
            'ip_address' => $ip,
        ]);

        if (!$viewLog->viewed) {
            $viewable->increment("views_{$locale}");
            $viewLog->viewed = true;
            $viewLog->save();
        }

        if (!$viewLog->country_code) {
            try {
                $reader = new Reader(public_path('assets/GeoLite2-Country.mmdb'));
                $record = $reader->country($ip);
                $viewLog->country_code = $record->country->isoCode;
                $viewLog->save();
            } catch (\Exception $e) {
                Log::error('GeoIP Error: ' . $e->getMessage());
            }
        }
    }
}
