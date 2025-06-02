<?php

use App\Http\Controllers\ProfileController;

Route::get('/statistics/visits', [\App\Http\Controllers\Admin\StatisticsController::class, 'visits'])
    ->middleware('encrypt_cookies', 'track_visitor')
    ->name('statistics.visits');


Route::group([
    'prefix' => '{locale}',
    'middleware' => ['auth', 'encrypt_cookies', 'encrypt_cookies']
], function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::post('/add-like/{news_id}/', [\App\Http\Controllers\Public\LikesController::class, 'store'])->name('like.store');
    Route::post('/add-comment/{news_id}/', [\App\Http\Controllers\Public\CommentsController::class, 'store'])->name('comment.store');
    Route::delete('/comment-{comment_id}/delete', [\App\Http\Controllers\Public\CommentsController::class, 'destroy'])->name('comment.delete');
});
