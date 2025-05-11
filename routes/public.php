<?php
$locale = Request::segment(1);

// Проверка на корректность локали
if (in_array($locale, ['ru', 'kz', 'en'])) {
    app()->setLocale($locale);
} else {
    app()->setLocale('kz');
}

Route::get('/dashboard', function () {
    return redirect(route('home'));
})->middleware(['auth', 'verified', 'encrypt_cookies', 'track_visitor'])->name('dashboard');

Route::group([
    'middleware' => ['encrypt_cookies', 'track_visitor'],
    'prefix' => $locale,
], function () {
    Route::get('/', [\App\Http\Controllers\Public\HomeController::class, 'index'])->name('home');
    Route::get('/news', [\App\Http\Controllers\Public\NewsController::class, 'index'])->name('news.index');
    Route::get('/news/{slug}', [\App\Http\Controllers\Public\NewsController::class, 'show'])->name('news.show');
    Route::get('/gallery', [\App\Http\Controllers\Public\GalleryController::class, 'index'])->name('gallery.index');
    Route::get('/awards', [\App\Http\Controllers\Public\AwardsController::class, 'index'])->name('awards.index');

    Route::get('/structure', [\App\Http\Controllers\Public\DivisionsController::class, 'index'])->name('structure.index');
    Route::get('/structure/{slug}', [\App\Http\Controllers\Public\DivisionsController::class, 'show'])->name('structure.show');

    Route::get('/faculties', [\App\Http\Controllers\Public\FacultiesController::class, 'index'])->name('faculties.index');
    Route::get('/faculties/{slug}', [\App\Http\Controllers\Public\FacultiesController::class, 'show'])->name('faculties.show');

    Route::get('/ads', [\App\Http\Controllers\Public\AdsController::class, 'index'])->name('ads.index');
    Route::get('/ads/{slug}', [\App\Http\Controllers\Public\AdsController::class, 'show'])->name('ads.show');

    Route::get('/search', [\App\Http\Controllers\Public\SearchController::class, 'index'])->name('search.index');
    Route::get('/compliance', [\App\Http\Controllers\Public\KomplaensController::class, 'show'])->name('komplaens.show');

    Route::get('/graduates', [\App\Http\Controllers\Public\GraduatesController::class, 'index'])->name('graduates.index');
    Route::get('/graduates/search', [\App\Http\Controllers\Public\GraduatesController::class, 'search'])->name('graduates.search');


    Route::get('/for-the-applicant', [\App\Http\Controllers\Public\ApplicantController::class, 'index'])->name('applicant.index');
    Route::get('/for-the-student', [\App\Http\Controllers\Public\StudentsController::class, 'index'])->name('applicant.index');

    Route::get('/dis-sovet', [\App\Http\Controllers\Public\DissovetController::class, 'index'])->name('dissovet.index');
    Route::get('/dis-sovet/documents', [\App\Http\Controllers\Public\DissovetController::class, 'documents'])->name('dissovet.documents');
    Route::get('/dis-sovet/reports', [\App\Http\Controllers\Public\DissovetController::class, 'reports'])->name('dissovet.reports');
    Route::get('/dis-sovet/information', [\App\Http\Controllers\Public\DissovetController::class, 'information'])->name('dissovet.information');
    Route::get('/dis-sovet/staff', [\App\Http\Controllers\Public\DissovetController::class, 'staff'])->name('dissovet.staff');
    Route::get('/dis-sovet/programs', [\App\Http\Controllers\Public\DissovetController::class, 'programs'])->name('dissovet.programs');
    Route::get('/dis-sovet/programs/{program_id}/announcement', [\App\Http\Controllers\Public\DissovetController::class, 'announcement'])->name('dissovet.announcement');
});

Route::get('/', function () {
    return redirect('/kz');
});
