<?php

use App\Models\Department;
use Illuminate\Support\Facades\Route;

require __DIR__ . '/utils.php';

require __DIR__ . '/moonshine.php';

require __DIR__ . '/filemanager.php';

Route::group([
    'prefix' => LaravelLocalization::setLocale(),
    'middleware' => [
        'localeSessionRedirect',
        'localizationRedirect',
        'localeViewPath',
        'web',
        'track_visitor',
    ],
], function () {
    require __DIR__ . '/public.php';
    require __DIR__ . '/auth.php';
    require __DIR__ . '/admin.php';

    Route::view('/chatbot', 'widgets.chatBot');
    Route::view('/chatbot-page', 'widgets.chatbotFullScreen');
    Route::post('/api/chat', [\App\Http\Controllers\Ai\ChatBotController::class, 'chat'])
        ->name('chat.post');
});
