<!doctype html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="/assets/css/all.min.css">
    @vite('resources/css/app.css')
    @stack('styles')
    <title>SKMA</title>
</head>
<body class="h-screen overflow-hidden flex">
<!-- Sidebar -->
<div id="sidebar"
     class="bg-gray-200 text-primary-main transition-width duration-500 ease w-64 h-full overflow-y-auto z-20 shadow-[3px_0px_11px_1px_#00000024]">
    <div id="sidebar-actions" class="flex justify-between items-center p-4 text-2xl">
        <div id="lang-switcher" class="flex text-lg font-bold items-center">
            @php
                $locales = ['en', 'ru', 'kz'];
            @endphp

            @foreach ($locales as $locale)
                <a href="{{ url($locale) }}" class="hover:text-primary-light mx-1">
                    {{ strtoupper($locale) }}
                </a>
            @endforeach
            <button class="ml-4 hover:text-primary-light"><i class="fas fa-eye"></i></button>
        </div>
        <div>
            <button id="toggle-menu">
                <i id="close-icon" class="fa fa-times" aria-hidden="true"></i>
                <i id="bars-icon" class="fa fa-bars hidden" aria-hidden="true"></i>
            </button>
        </div>
    </div>
    <div class="px-4">
        <span class="block bg-primary-light h-0.5"></span>
    </div>
    <div class="p-4 text-lg font-bold">
        <a href="/" class="flex justify-center">
            <img class="w-20" src="/assets/images/logos/logo.png" alt="">
        </a>
    </div>
    <form class="relative px-4 mt-4" id="search-form">
        <input
            type="text"
            placeholder="Поиск..."
            class="w-full p-3 border-r-0 border-l-0 border-t-0 border-b-primary-light text-primary-main placeholder-primary-main bg-gray-200 focus:outline-none focus:ring-0 focus:ring-primary-light focus:border-primary-light"
        />
        <button type="submit" class="absolute inset-y-0 right-6 flex items-center text-primary-main">
            <i class="fa fa-search"></i>
        </button>
    </form>
    <nav id="menu" class="mt-8">
        <ul class="text-md">
            @foreach ($menus as $menu)
                <li class="relative">
                    @if ($menu->children->isNotEmpty())
                        <!-- Родитель с подменю -->
                        <div
                            class="py-2 px-4 border-b border-b-primary-secondary cursor-pointer hover:bg-primary-secondary transition-colors duration-300 flex justify-between items-center submenu-toggle">
                        <span>
                            {!! $menu->icon !!}<span class="ml-4">{{ $menu->name_ru }}</span>
                        </span>
                            <i class="far fa-chevron-down"></i>
                        </div>
                        <!-- Подменю -->
                        <ul class="hidden pl-4">
                            @foreach ($menu->children as $child)
                                <li class="">
                                    <a href="{{ $child->link_ru }}"
                                       class="block py-2 border-b px-2 border-b-primary-secondary hover:bg-primary-secondary transition-colors duration-300">
                                        {!! $child->icon !!}<span class="ml-4">{{ $child->name_ru }}</span>
                                    </a>
                                </li>
                            @endforeach
                        </ul>
                    @else
                        <!-- Родитель без подменю -->
                        <a class="block py-2 px-4 border-b border-b-primary-secondary hover:bg-primary-secondary transition-colors duration-300"
                           href="{{ $menu->link_ru }}">
                            {!! $menu->icon !!}<span class="ml-4">{{ $menu->name_ru }}</span>
                        </a>
                    @endif
                </li>
            @endforeach
        </ul>
    </nav>
</div>
<div id="content" class="flex-1 bg-gray-100 transition-all duration-500 overflow-y-auto">
    <div class="bg-primary-main p-4">
        <div class="flex items-center justify-between">
            <div></div>
            <div class="text-gray-100">
                <a href="##">Авторизация</a>
                <a href="##" class="ml-3">Регистрация</a>
            </div>
        </div>
    </div>

    <div class="p-4">@yield('content')</div>

    <footer class="mt-20 border-t bg-primary-main border-t-primary-main p-4">
        <div class="flex justify-between items-center">
            <div>Ссылки 1</div>
            <div>Ссылки 2</div>
            <div>Ссылки 3</div>
        </div>
        <div>Информация</div>
    </footer>
</div>
<script src="/assets/js/pro.min.js"></script>
@vite('resources/js/app.js')
@stack('scripts')
</body>
</html>
