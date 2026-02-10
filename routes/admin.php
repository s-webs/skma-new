<?php

use App\Http\Controllers\ProfileController;

Route::get('/statistics/visits', [\App\Http\Controllers\Admin\StatisticsController::class, 'visits'])
    ->middleware('encrypt_cookies', 'track_visitor')
    ->name('statistics.visits');


Route::group([
    'middleware' => [
        'auth'
    ]
], function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::post('/add-like/{news_id}/', [\App\Http\Controllers\Public\LikesController::class, 'store'])->name('like.store');
    Route::post('/add-comment/{news_id}/', [\App\Http\Controllers\Public\CommentsController::class, 'store'])->name('comment.store');
    Route::delete('/comment-{comment_id}/delete', [\App\Http\Controllers\Public\CommentsController::class, 'destroy'])->name('comment.delete');

    Route::get('ai-check', [\App\Http\Controllers\Ai\AiCheckController::class, 'index'])->name('ai.check');
    Route::post('ai-check', [\App\Http\Controllers\Ai\AiCheckController::class, 'check'])->name('ai.check.submit');
    Route::post('ai-check/prepare-pdf', [\App\Http\Controllers\Ai\AiCheckController::class, 'preparePdf'])->name('ai.check.prepare-pdf');
    Route::get('/ai-check/pdf', [\App\Http\Controllers\Ai\AiCheckController::class, 'downloadPdf'])->name('ai.check.pdf'); // legacy
    Route::get('ai-check/status/{job}', [\App\Http\Controllers\Ai\AiCheckController::class, 'status'])->name('ai.check.status');
    Route::get('ai-check/result/{job}', [\App\Http\Controllers\Ai\AiCheckController::class, 'result'])->name('ai.check.result');
    Route::get('ai-check/result/{job}/pdf/{lang}', [\App\Http\Controllers\Ai\AiCheckController::class, 'downloadResultPdf'])->name('ai.check.result.pdf');
    Route::get('ai-check/clear', [\App\Http\Controllers\Ai\AiCheckController::class, 'clearReport'])->name('ai.check.clear');
});
