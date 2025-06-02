<?php

use Illuminate\Support\Facades\Route;

require __DIR__ . '/utils.php';

require __DIR__ . '/moonshine.php';

require __DIR__ . '/filemanager.php';

Route::group([
    'prefix' => LaravelLocalization::setLocale(),
    'middleware' => [
        'localeSessionRedirect',
        'localizationRedirect',
        'localeViewPath',
        'web',
        'track_visitor',
    ],
], function () {
    require __DIR__ . '/public.php';
    require __DIR__ . '/auth.php';
    require __DIR__ . '/admin.php';
});
