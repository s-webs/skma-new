<?php

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

Route::group([
    'middleware' => [
    ],
], function () {
    Route::post('/sanctum/token', function (Request $request) {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
            'device_name' => 'required',
        ]);

        $user = User::where('email', $request->email)->first();

        if (!$user || !Hash::check($request->password, $user->password)) {
            throw ValidationException::withMessages([
                'email' => ['The provided credentials are incorrect.'],
            ]);
        }

        return $user->createToken($request->device_name)->plainTextToken;
    });
    Route::middleware('auth:sanctum')->get('/me', function (Request $request) {
        return $request->user();
    });
});


Route::group([
    'middleware' => [
        'auth:sanctum',
    ],
], function () {
    Route::get('/news-index', [\App\Http\Controllers\Api\NewsController::class, 'getNews']);
    Route::put('/news/{news}/like', [\App\Http\Controllers\Api\NewsController::class, 'like']);   // поставить лайк (идемпотентно)
    Route::delete('/news/{news}/like', [\App\Http\Controllers\Api\NewsController::class, 'unlike']);
    Route::get('/news/{news}/comments', [\App\Http\Controllers\Api\CommentsController::class, 'index']);
    Route::post('/news/{news}/comments', [\App\Http\Controllers\Api\CommentsController::class, 'store']);   // добавить
    Route::delete('/comments/{comment}', [\App\Http\Controllers\Api\CommentsController::class, 'destroy']); // удалить своё
});
