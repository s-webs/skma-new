<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ViewLogsController extends Controller
{
    public function test()
    {
        $ip = request()->ip();
        $locale = app()->getLocale();

        dd($ip, $locale);
    }
}
