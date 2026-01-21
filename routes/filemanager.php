<?php

use App\Http\Controllers\Admin\FilesController;
use Illuminate\Support\Facades\Route;


Route::group(['middleware' => ['encrypt_cookies', 'track_visitor']], function () {
    Route::get('/fmanager', [FilesController::class, 'index'])->name('fmanager.index');
    Route::get('/s-files', [FilesController::class, 'files'])->middleware('filemanager.ratelimit:general');
    Route::post('/s-files/upload', [FilesController::class, 'upload'])->middleware('filemanager.ratelimit:upload');
    Route::post('/s-files/create-folder', [FilesController::class, 'createFolder'])->middleware('filemanager.ratelimit:general');
    Route::post('/s-files/delete', [FilesController::class, 'delete'])->middleware('filemanager.ratelimit:delete');
    Route::post('/s-files/delete-folder', [FilesController::class, 'deleteFolder'])->middleware('filemanager.ratelimit:delete');
    Route::post('/s-files/rename', [FilesController::class, 'rename'])->middleware('filemanager.ratelimit:general');
    Route::get('/s-files/download-folder', [FilesController::class, 'downloadFolder'])->middleware('filemanager.ratelimit:general');
    Route::post('/s-files/download-files', [FilesController::class, 'downloadFiles'])->middleware('filemanager.ratelimit:general');



    Route::get('test-field', function () {
        return view('utils.fmanager-field');
    });
});

