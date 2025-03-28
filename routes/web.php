<?php

use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\Auth\ConfirmablePasswordController;
use App\Http\Controllers\Auth\EmailVerificationNotificationController;
use App\Http\Controllers\Auth\EmailVerificationPromptController;
use App\Http\Controllers\Auth\NewPasswordController;
use App\Http\Controllers\Auth\PasswordController;
use App\Http\Controllers\Auth\PasswordResetLinkController;
use App\Http\Controllers\Auth\RegisteredUserController;
use App\Http\Controllers\Auth\VerifyEmailController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

$locale = Request::segment(1);

if (in_array($locale, ['ru', 'kz', 'en'])) {
    app()->setLocale($locale);
} else {
    app()->setLocale('ru');
    $locale = '';
}

Route::get('/mail', function () {
    return view('mails.confirm-email');
});

Route::group([
    'prefix' => $locale,
], function () {
    Route::get('/', [\App\Http\Controllers\Public\HomeController::class, 'index'])->name('home');
    Route::get('/news', [\App\Http\Controllers\Public\NewsController::class, 'index'])->name('news.index');
    Route::get('/news/{slug}', [\App\Http\Controllers\Public\NewsController::class, 'show'])->name('news.show');
//    Route::get('/academy-structure', [\App\Http\Controllers\Public\HomeController::class, 'academyStructure'])->name('academy.structure');
    Route::get('/gallery', [\App\Http\Controllers\Public\GalleryController::class, 'index'])->name('gallery.index');
    Route::get('/awards', [\App\Http\Controllers\Public\AwardsController::class, 'index'])->name('awards.index');

    Route::get('/structure', [\App\Http\Controllers\Public\DivisionsController::class, 'index'])->name('structure.index');
    Route::get('/structure/{slug}', [\App\Http\Controllers\Public\DivisionsController::class, 'show'])->name('structure.show');

    Route::get('/faculties', [\App\Http\Controllers\Public\FacultiesController::class, 'index'])->name('faculties.index');
    Route::get('/faculties/{slug}', [\App\Http\Controllers\Public\FacultiesController::class, 'show'])->name('faculties.show');

    Route::get('/ads', [\App\Http\Controllers\Public\AdsController::class, 'index'])->name('ads.index');
    Route::get('/ads/{slug}', [\App\Http\Controllers\Public\AdsController::class, 'show'])->name('ads.show');

    Route::get('/statistics/visits', [\App\Http\Controllers\Admin\StatisticsController::class, 'visits'])->name('statistics.visits');
    Route::get('/search', [\App\Http\Controllers\Public\SearchController::class, 'index'])->name('search.index');

    Route::get('for-the-applicant', [\App\Http\Controllers\Public\ApplicantController::class, 'index'])->name('applicant.index');
});

Route::get('/dashboard', function () {
    return redirect(route('home'));
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::post('/add-like/{news_id}/', [\App\Http\Controllers\Public\LikesController::class, 'store'])->name('like.store');
    Route::post('/add-comment/{news_id}/', [\App\Http\Controllers\Public\CommentsController::class, 'store'])->name('comment.store');
    Route::delete('/comment-{comment_id}/delete', [\App\Http\Controllers\Public\CommentsController::class, 'destroy'])->name('comment.delete');
});

require __DIR__ . '/auth.php';
