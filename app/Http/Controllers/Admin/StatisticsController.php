<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ViewLog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use League\ISO3166\ISO3166;

class StatisticsController extends Controller
{
    public function visits()
    {
        $visits = ViewLog::select('country_code', DB::raw('count(*) as count'))
            ->groupBy('country_code')
            ->orderByDesc('count')
            ->get();

        $countries = [];
        $iso3166 = new ISO3166();

        foreach ($visits as $visit) {
            if ($visit->country_code) {
                $countryName = $iso3166->getName($visit->country_code);
                $countries[] = [
                    'code' => $visit->country_code,
                    'name' => $countryName,
                    'count' => $visit->count,
                    'flag' => "https://flagcdn.com/40x30/{$visit->country_code}.png", // Используем flagcdn
                ];
            }
        }

        return view('pages.statistics.visits', compact('countries'));
    }
}
