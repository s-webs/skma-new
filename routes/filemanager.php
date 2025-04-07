<?php

use App\Http\Controllers\Admin\FilesController;
use Illuminate\Support\Facades\Route;




Route::get('/fmanager', [FilesController::class, 'index'])->name('fmanager.index');
Route::get('/files', [FilesController::class, 'files']);
Route::post('/files/upload', [FilesController::class, 'upload']);
Route::post('/files/create-folder', [FilesController::class, 'createFolder']);
Route::post('/files/delete', [FilesController::class, 'delete']);
Route::post('/files/delete-folder', [FilesController::class, 'deleteFolder']);

