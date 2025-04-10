<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Department;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class UtilsController extends Controller
{

    public function pushDepartmentsPage()
    {
        $pages = DB::connection('old_database')
            ->table('pages')
            ->where('ru_title', 'like', '%Кафедра%')
            ->get();


        foreach ($pages as $page) {
            $department = new Department();
            $department->name_ru = $page->ru_title;
            $department->name_kz = $page->kk_title;
            $department->name_en = $page->en_title;
            $department->description_ru = $page->ru_content;
            $department->description_kz = $page->kk_content;
            $department->description_en = $page->en_content;
            $department->save();
            dump('Процедура переноса прошла успешно - ' . $department->title_ru);
        }

        return true;
    }

}
