<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

$locale = Request::segment(1);

if (in_array($locale, ['ru', 'kz', 'en'])) {
    app()->setLocale($locale);
} else {
    app()->setLocale('ru');
    $locale = '';
}

Route::group([
    'prefix' => $locale,
], function () {
    Route::get('/', [\App\Http\Controllers\Public\HomeController::class, 'index'])->name('home');
    Route::get('/news', [\App\Http\Controllers\Public\NewsController::class, 'index'])->name('news.index');
    Route::get('/news/{slug}', [\App\Http\Controllers\Public\NewsController::class, 'show'])->name('news.show');
    Route::get('/academy-structure', [\App\Http\Controllers\Public\HomeController::class, 'academyStructure'])->name('academy.structure');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__ . '/auth.php';
