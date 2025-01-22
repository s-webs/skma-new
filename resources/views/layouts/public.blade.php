<!doctype html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="/assets/css/all.min.css">
    <link rel="stylesheet" href="/assets/css/bvi.min.css">
    @vite('resources/css/app.css')
    @stack('styles')
    <title>SKMA</title>
</head>
<body class="">
<div class="h-screen overflow-hidden flex">
    <!-- Sidebar -->

    <style>
        #sidebar-mobile.active {
            left: 0;
            transition: left;
            transition-duration: 0.3s;
        }

        #sidebar-mobile.disable {
            left: -100%;
            transition: left;
            transition-duration: 0.3s;
        }
    </style>

    <div id="sidebar"
         class="bg-gray-100 text-primary-main transition-width duration-500 ease w-64 h-full overflow-y-auto z-20 shadow-[6px_1px_19px_0px_rgba(0,_0,_0,_0.2)] hidden lg:block">
        <div id="sidebar-actions" class="flex justify-between items-center p-4 text-2xl">
            <div id="lang-switcher" class="flex text-lg font-bold items-center">
                <a href="/kz{{$kzLink ? '/' . $kzLink : ''}}{{$page ?? ''}}" class="hover:text-primary-light mx-1">
                    KZ
                </a>
                <a href="/ru{{$ruLink ? '/' . $ruLink : ''}}{{$page ?? ''}}" class="hover:text-primary-light mx-1">
                    RU
                </a>
                <a href="/en{{$enLink ? '/' . $enLink : ''}}{{$page ?? ''}}" class="hover:text-primary-light mx-1">
                    EN
                </a>
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
            <a href="{{ route('home') }}" class="flex justify-center">
                <img id="full-logo" class="w-48" src="/assets/images/logos/skma-logo.svg" alt="">
                <img id="small-logo" class="w-24 hidden" src="/assets/images/logos/logo.png" alt="">
            </a>
        </div>
        <form class="relative px-4 mt-4" id="search-form">
            <input
                type="text"
                placeholder="Поиск..."
                class="w-full p-3 border-r-0 border-l-0 border-t-0 border-b-primary-light text-primary-main placeholder-primary-main bg-gray-100 focus:outline-none focus:ring-0 focus:ring-primary-light focus:border-primary-light"
            />
            <button type="submit" class="absolute inset-y-0 right-6 flex items-center text-primary-main">
                <i class="fa fa-search"></i>
            </button>
        </form>
        <nav id="menu" class="mt-8">
            <ul class="text-md px-4">
                @foreach ($menus as $menu)
                    <li class="relative">
                        @if ($menu->children->isNotEmpty())
                            <!-- Родитель с подменю -->
                            <div
                                class="py-2 px-4 border-b border-b-primary-secondary cursor-pointer hover:bg-primary-secondary transition-colors duration-300 flex justify-between items-center submenu-toggle">
                        <span>
                            {!! $menu->icon !!}<span class="ml-4">{{ $menu->getProperty('name') }}</span>
                        </span>
                                <i class="far fa-chevron-down"></i>
                            </div>
                            <!-- Подменю -->
                            <ul class="hidden pl-4">
                                @foreach ($menu->children as $child)
                                    <li class="">
                                        <a href="{{ $child->getProperty('link') }}"
                                           class="block py-2 border-b px-2 border-b-primary-secondary hover:bg-primary-secondary transition-colors duration-300">
                                            {!! $child->icon !!}<span class="ml-4">{{ $child->getProperty('name') }}</span>
                                        </a>
                                    </li>
                                @endforeach
                            </ul>
                        @else
                            <!-- Родитель без подменю -->
                            <a class="block py-2 px-4 border-b border-b-primary-secondary hover:bg-primary-secondary transition-colors duration-300"
                               href="{{ $menu->getProperty('link') }}">
                                {!! $menu->icon !!}<span class="ml-4">{{ $menu->getProperty('name') }}</span>
                            </a>
                        @endif
                    </li>
                @endforeach
            </ul>
        </nav>
    </div>

    <div id="sidebar-mobile"
         class="disable bg-gray-100 text-primary-main transition-width duration-500 ease w-full h-full z-20 lg:hidden overflow-y-auto absolute left-0">
        <div id="sidebar-actions" class="flex justify-between items-center p-4 text-2xl">
            <div id="lang-switcher" class="flex text-lg font-bold items-center"></div>
            <div>
                <button id="close-mobile-sidebar">
                    <i id="close-icon" class="fa fa-times" aria-hidden="true"></i>
                </button>
            </div>
        </div>
        <div class="px-4">
            <span class="block bg-primary-light h-0.5"></span>
        </div>
        <div class="p-4 text-lg font-bold">
            <a href="{{ route('home') }}" class="flex justify-center">
                <img id="full-logo" class="w-48" src="/assets/images/logos/skma-logo.svg" alt="">
                <img id="small-logo" class="w-24 hidden" src="/assets/images/logos/logo.png" alt="">
            </a>
        </div>
        <form class="relative px-4 mt-4" id="search-form">
            <input
                type="text"
                placeholder="Поиск..."
                class="w-full p-3 border-r-0 border-l-0 border-t-0 border-b-primary-light text-primary-main placeholder-primary-main bg-gray-100 focus:outline-none focus:ring-0 focus:ring-primary-light focus:border-primary-light"
            />
            <button type="submit" class="absolute inset-y-0 right-6 flex items-center text-primary-main">
                <i class="fa fa-search"></i>
            </button>
        </form>
        <nav id="menu" class="mt-8">
            <ul class="text-md px-4">
                @foreach ($menus as $menu)
                    <li class="relative">
                        @if ($menu->children->isNotEmpty())
                            <!-- Родитель с подменю -->
                            <div
                                class="py-2 px-4 border-b border-b-primary-secondary cursor-pointer hover:bg-primary-secondary transition-colors duration-300 flex justify-between items-center submenu-toggle">
                        <span>
                            {!! $menu->icon !!}<span class="ml-4">{{ $menu->getProperty('name') }}</span>
                        </span>
                                <i class="far fa-chevron-down"></i>
                            </div>
                            <!-- Подменю -->
                            <ul class="hidden pl-4">
                                @foreach ($menu->children as $child)
                                    <li class="">
                                        <a href="{{ $child->getProperty('link') }}"
                                           class="block py-2 border-b px-2 border-b-primary-secondary hover:bg-primary-secondary transition-colors duration-300">
                                            {!! $child->icon !!}<span class="ml-4">{{ $child->getProperty('name') }}</span>
                                        </a>
                                    </li>
                                @endforeach
                            </ul>
                        @else
                            <!-- Родитель без подменю -->
                            <a class="block py-2 px-4 border-b border-b-primary-secondary hover:bg-primary-secondary transition-colors duration-300"
                               href="{{ $menu->getProperty('link') }}">
                                {!! $menu->icon !!}<span class="ml-4">{{ $menu->getProperty('name') }}</span>
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
                <div>
                    <button id="open-mobile-sidebar" class="text-white">
                        <i id="mobile-bars-icon" class="fa fa-bars lg:hidden" aria-hidden="true"></i>
                    </button>
                    <button id="enable-pc-impaired" class="ml-4 text-white hover:text-primary-light"><i class="fas fa-eye"></i></button>
                    <a class="text-white" href="/crm" target="_blank">ADMIN PANEL</a>
                </div>
                <div class="text-gray-100 hidden lg:block">
                    <a href="##">Авторизация</a>
                    <a href="##" class="ml-3">Регистрация</a>
                </div>
                <div class="flex lg:hidden">
                    <div class="mr-4 text-white">
                        <a href="/kz{{$kzLink ? '/' . $kzLink : ''}}{{$page ?? ''}}"
                           class="hover:text-primary-light mx-0.5">
                            KZ
                        </a>
                        <a href="/ru{{$ruLink ? '/' . $ruLink : ''}}{{$page ?? ''}}"
                           class="hover:text-primary-light mx-0.5">
                            RU
                        </a>
                        <a href="/en{{$enLink ? '/' . $enLink : ''}}{{$page ?? ''}}"
                           class="hover:text-primary-light mx-0.5">
                            EN
                        </a>
                    </div>
                    <div>
                        <button class="text-white">
                            <i class="fas fa-eye"></i>
                        </button>
                    </div>
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
</div>
<script src="/assets/js/pro.min.js"></script>
<script src="/assets/js/bvi.min.js"></script>
@vite('resources/js/app.js')
@stack('scripts')
</body>
</html>
