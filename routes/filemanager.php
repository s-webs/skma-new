<?php

use App\Http\Controllers\Admin\FilesController;
use Illuminate\Support\Facades\Route;




Route::get('/fmanager', [FilesController::class, 'index'])->name('fmanager.index');
Route::get('/s-files', [FilesController::class, 'files']);
Route::post('/s-files/upload', [FilesController::class, 'upload']);
Route::post('/s-files/create-folder', [FilesController::class, 'createFolder']);
Route::post('/s-files/delete', [FilesController::class, 'delete']);
Route::post('/s-files/delete-folder', [FilesController::class, 'deleteFolder']);

