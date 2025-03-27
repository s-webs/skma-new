<!doctype html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
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
<body class="bg-[var(--color-halftone)] font-openSans">

@include('layouts.components.search')

@include('layouts.components.mobile-sidebar', compact('menus'))

@include('layouts.components.header', compact('menus'))

@yield('content')

@include('layouts.components.footer')
</body>
<script src="/assets/js/pro.min.js"></script>
<script src="/assets/js/bvi.min.js"></script>
@vite('resources/js/app.js')
@stack('scripts')
</body>
</html>
