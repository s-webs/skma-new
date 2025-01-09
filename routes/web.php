<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::get('/', function () {
    return redirect(app()->getLocale()); // Перенаправляем на текущий язык
});

Route::get('/{locale}', [\App\Http\Controllers\Public\HomeController::class, 'index'])->name('home');

Route::group(['prefix' => '{locale}', 'middleware' => 'setLocale'], function () {

});

require __DIR__ . '/auth.php';
