<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use App\Models\DisSovetAnnouncement;
use App\Models\DisSovetDocument;
use App\Models\DisSovetInformation;
use App\Models\DisSovetReport;
use App\Models\DisSovetStaff;
use App\Models\EducationProgram;
use Illuminate\Http\Request;

class DissovetController extends Controller
{
    public function index()
    {
        return view('pages.dis_sovet.index');
    }

    public function documents()
    {
        $documents = DisSovetDocument::all();

        return view('pages.dis_sovet.documents', compact('documents'));
    }

    public function reports()
    {
        $documents = DisSovetReport::all();

        return view('pages.dis_sovet.reports', compact('documents'));
    }

    public function information()
    {
        $documents = DisSovetInformation::all();

        return view('pages.dis_sovet.information', compact('documents'));
    }

    public function staff()
    {
        $staff = DisSovetStaff::query()->first();

        $files = collect(json_decode($staff->getProperty('file')))
            ->map(function ($path) {
                return [
                    'path' => $path,
                    'name' => basename($path),
                ];
            });

        return view('pages.dis_sovet.staff', compact('staff', 'files'));
    }

    public function programs()
    {
        $programs = EducationProgram::all();
        return view('pages.dis_sovet.programs', compact('programs'));
    }

    public function announcement($program_id)
    {
        $program = EducationProgram::query()->findOrFail($program_id);

        // Получаем все объявления с преобразованными данными файлов
        $announcements = $program->announcements()->get()->map(function ($announcement) {
            // Проверяем, есть ли поле files и преобразуем его
            $rawFiles = $announcement->files ?? '[]'; // Получаем файл (может быть строкой или массивом)

            // Декодируем как JSON, если это строка
            if (is_string($rawFiles)) {
                $rawFiles = json_decode($rawFiles, true);
            }

            // Если это не массив, приводим к пустому массиву
            if (!is_array($rawFiles)) {
                $rawFiles = [];
            }

            // Преобразуем каждый файл в структуру ['path' => ..., 'name' => ...]
            $announcement->files = collect($rawFiles)->map(function ($file) {
                if (is_array($file) && isset($file['path'], $file['name'])) {
                    return $file;
                }

                return [
                    'path' => $file,
                    'name' => pathinfo($file, PATHINFO_FILENAME),
                ];
            });

            return $announcement;
        });

        // Передаем данные во view
        return view('pages.dis_sovet.announcements', compact('program', 'announcements'));
    }


}
