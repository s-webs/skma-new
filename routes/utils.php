<?php

Route::get('/mail', function () {
    return view('mails.confirm-email');
})->middleware(['encrypt_cookies', 'track_visitor']);

//Route::get('get-pages', [\App\Http\Controllers\Admin\UtilsController::class, 'pushDepartmentsPage']);
