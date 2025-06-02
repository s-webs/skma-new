<?php

use Mcamara\LaravelLocalization\Facades\LaravelLocalization;


Route::get('/dashboard', function () {
    return redirect(route('home'));
})->name('dashboard');

Route::get('/', [\App\Http\Controllers\Public\HomeController::class, 'index'])->name('home');

// NEWS
Route::get('/news', [\App\Http\Controllers\Public\NewsController::class, 'index'])->name('news.index');
Route::get('/news/{slug}', [\App\Http\Controllers\Public\NewsController::class, 'show'])->name('news.show');

// ADS
Route::get('/ads', [\App\Http\Controllers\Public\AdsController::class, 'index'])->name('ads.index');
Route::get('/ads/{slug}', [\App\Http\Controllers\Public\AdsController::class, 'show'])->name('ads.show');

// COMPLIANCE
Route::get('/compliance', [\App\Http\Controllers\Public\KomplaensController::class, 'show'])->name('komplaens.show');

// GALLERY
Route::get('/gallery', [\App\Http\Controllers\Public\GalleryController::class, 'index'])->name('gallery.index');

// AWARDS
Route::get('/awards', [\App\Http\Controllers\Public\AwardsController::class, 'index'])->name('awards.index');

// SEARCH
Route::get('/search', [\App\Http\Controllers\Public\SearchController::class, 'index'])->name('search.index');

// DIVISIONS
Route::get('/structure', [\App\Http\Controllers\Public\DivisionsController::class, 'index'])->name('structure.index');
Route::get('/structure/{slug}', [\App\Http\Controllers\Public\DivisionsController::class, 'show'])->name('structure.show');

// FACULTIES & DEPARTMENTS
Route::get('/faculties', [\App\Http\Controllers\Public\FacultiesController::class, 'index'])->name('faculties.index');
Route::get('/faculties/{slug}', [\App\Http\Controllers\Public\FacultiesController::class, 'show'])->name('faculties.show');

// GRADUATES
Route::get('/graduates', [\App\Http\Controllers\Public\GraduatesController::class, 'index'])->name('graduates.index');
Route::get('/graduates/search', [\App\Http\Controllers\Public\GraduatesController::class, 'search'])->name('graduates.search');

// FOR THE APPLICANT
Route::get('/for-the-applicant', [\App\Http\Controllers\Public\ApplicantController::class, 'index'])->name('applicant.index');

// FOR THE STUDENT
Route::get('/for-the-student', [\App\Http\Controllers\Public\StudentsController::class, 'index'])->name('students.index');

// DIS SOVET
Route::get('/dis-sovet', [\App\Http\Controllers\Public\DissovetController::class, 'index'])->name('dissovet.index');
Route::get('/dis-sovet/documents', [\App\Http\Controllers\Public\DissovetController::class, 'documents'])->name('dissovet.documents');
Route::get('/dis-sovet/reports', [\App\Http\Controllers\Public\DissovetController::class, 'reports'])->name('dissovet.reports');
Route::get('/dis-sovet/information', [\App\Http\Controllers\Public\DissovetController::class, 'information'])->name('dissovet.information');
Route::get('/dis-sovet/staff', [\App\Http\Controllers\Public\DissovetController::class, 'staff'])->name('dissovet.staff');
Route::get('/dis-sovet/programs', [\App\Http\Controllers\Public\DissovetController::class, 'programs'])->name('dissovet.programs');
Route::get('/dis-sovet/programs/{program_id}/announcement', [\App\Http\Controllers\Public\DissovetController::class, 'announcement'])->name('dissovet.announcement');

// PAGES
Route::get('/pages/{slug}', [\App\Http\Controllers\Public\CmsPagesController::class, 'show'])->name('cmspage.show');
