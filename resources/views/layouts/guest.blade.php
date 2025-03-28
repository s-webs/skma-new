<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Open+Sans:ital,wght@0,300..800;1,300..800&display=swap"
          rel="stylesheet">
    <link rel="stylesheet" href="/assets/css/all.min.css">
    <link rel="stylesheet" href="/assets/css/bvi.min.css">
    @vite('resources/css/app.css')
    <style>
        :root {
            --color-dark: {{ $activeTheme->dark }};
            --color-halftone: {{ $activeTheme->halftone }};
            --color-main: {{ $activeTheme->main }};
            --color-secondary: {{ $activeTheme->secondary }};
            --color-primary: {{ $activeTheme->primary }};
            --color-heading: {{ $activeTheme->heading }};
            --color-extra: {{ $activeTheme->extra }};
        }
    </style>
    <title>SKMA</title>
</head>
<body class="bg-white">
@include('layouts.components.top-header')
<div class="bg-white shadow-md h-[50px] md:h-[70px]">
    <a href="{{ route('home') }}"
       class="flex items-center justify-center bg-custom-main w-[74px] md:w-[104px] h-[70px] md:h-[100px] z-10 rounded-bl-2xl rounded-br-2xl shadow-md pb-[10px] pt-[5px] lg:pb-[20px] lg:pt-[8px] mx-auto">
        <object data="/assets/images/logos/logo.svg" type="image/svg+xml" class="w-full h-full"
                style="pointer-events: none;">
            <img src="/assets/images/logos/logo.png" alt="logo">
        </object>
    </a>
</div>
<div class="flex flex-col sm:justify-center items-center pt-6 sm:pt-0 bg-[var(--color-main)])]">
    <div class="w-full sm:max-w-md">
        @yield('content')
    </div>
</div>
<script src="/assets/js/pro.min.js"></script>
<script src="/assets/js/bvi.min.js"></script>
@vite('resources/js/app.js')
</body>
</html>
