<?php

use App\Http\Controllers\Admin\FilesController;
use Illuminate\Support\Facades\Route;


Route::group(['middleware' => ['encrypt_cookies', 'track_visitor']],function () {
    Route::get('/fmanager', [FilesController::class, 'index'])->name('fmanager.index');
    Route::get('/s-files', [FilesController::class, 'files']);
    Route::post('/s-files/upload', [FilesController::class, 'upload']);
    Route::post('/s-files/create-folder', [FilesController::class, 'createFolder']);
    Route::post('/s-files/delete', [FilesController::class, 'delete']);
    Route::post('/s-files/delete-folder', [FilesController::class, 'deleteFolder']);

    Route::get('test-field', function () {
        return view('utils.fmanager-field');
    });
});

