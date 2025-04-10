<?php

Route::get('/mail', function () {
    return view('mails.confirm-email');
});

//Route::get('get-pages', [\App\Http\Controllers\Admin\UtilsController::class, 'pushDepartmentsPage']);
