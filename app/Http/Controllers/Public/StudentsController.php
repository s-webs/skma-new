<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use App\Models\ForStudent;
use App\Models\Service;
use Illuminate\Http\Request;

class StudentsController extends Controller
{
    public function index()
    {
        $services = Service::all();
        $information = ForStudent::query()->first();
        $scheduleLessons = collect(json_decode($information->schedule_lesson, true))
            ->map(function ($item) {
                $locale = app()->getLocale();
                $localizedKey = "shedule_title_{$locale}";

                return [
                    'link' => $item['link'] ?? null,
                    'title' => $item[$localizedKey] ?? null,
                ];
            });

        $scheduleExam = collect(json_decode($information->schedule_exam, true))
            ->map(function ($item) {
                $locale = app()->getLocale();
                $localizedKey = "shedule_title_{$locale}";

                return [
                    'link' => $item['link'] ?? null,
                    'title' => $item[$localizedKey] ?? null,
                ];
            });

        return view('pages.student.index', compact('services', 'information', 'scheduleLessons', 'scheduleExam'));
    }
}
