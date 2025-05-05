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
        $announcements = $program->announcements()->get();

        return view('pages.dis_sovet.announcements', compact('program'));
    }
}
