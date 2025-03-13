<?php

namespace App\Http\Controllers;

use App\Models\Theme;

abstract class Controller
{
    protected $activeTheme;

    public function __construct()
    {
        $this->activeTheme = Theme::query()->where('active', true)->first();
    }
}
