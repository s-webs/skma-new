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

        if ($information->academic_calendars) {
            $academic_calendars = scanDirectory($information->academic_calendars, 'uploads', skipTopLevels: 1, maxDepth: 5);
            $information->academic_calendars = $academic_calendars;
        }

        // 🔽 Локализация каталога элективов
        $locale = app()->getLocale();
        $electiveField = "electiveCatalog_{$locale}";

        if (!empty($information->$electiveField)) {
            $elective_catalog = scanDirectory($information->$electiveField, 'uploads', skipTopLevels: 2, maxDepth: 5);
            $information->elective_catalog = $elective_catalog;
        }

        return view('pages.student.index', compact('services', 'information', 'scheduleLessons', 'scheduleExam'));
    }

}
