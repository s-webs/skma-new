<?php

return [
    'defaultLocale' => env('APP_LOCALE', 'kz'),
    'hideDefaultLocaleInURL' => false,
    'useAcceptLanguageHeader' => false,
    'supportedLocales' => [
        'ru' => ['name' => 'Русский', 'script' => 'Cyrl', 'native' => 'Русский'],
        'kz' => ['name' => 'Қазақша', 'script' => 'Cyrl', 'native' => 'Қазақша'],
        'en' => ['name' => 'English', 'script' => 'Latn', 'native' => 'English'],
    ],
];
