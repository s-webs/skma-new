<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ViewLog;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use League\ISO3166\ISO3166;

class StatisticsController extends Controller
{
    public function visits()
    {
        $periods = [
            'today' => Carbon::today(),
            'week' => Carbon::today()->subWeek(),
            'month' => Carbon::today()->subMonth(),
            'year' => Carbon::today()->subYear(),
        ];

        $statistics = [];
        $iso3166 = new ISO3166();

        foreach ($periods as $periodName => $startDate) {
            $visits = ViewLog::select('country_code', DB::raw('count(*) as count'))
                ->where('created_at', '>=', $startDate)
                ->groupBy('country_code')
                ->orderByDesc('count')
                ->get();

            $countries = [];
            foreach ($visits as $visit) {
                if ($visit->country_code) {
                    try {
                        $countryInfo = $iso3166->alpha2($visit->country_code);
                        $countries[] = [
                            'code' => $visit->country_code,
                            'name' => $countryInfo['name'],
                            'count' => $visit->count,
                            'flag' => 'https://flagcdn.com/w20/' . mb_strtolower($visit->country_code) . '.png',
                        ];
                    } catch (\Exception $e) {
                        Log::error("ISO3166 Error: " . $e->getMessage() . " for country code: " . $visit->country_code);
                        $countries[] = [
                            'code' => $visit->country_code,
                            'name' => "Unknown",
                            'count' => $visit->count,
                            'flag' => null,
                        ];
                    }
                }
            }

            $statistics[$periodName] = $countries;
        }

        return view('pages.statistics.visits', compact('statistics'));
    }
}
