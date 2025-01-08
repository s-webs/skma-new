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
     class="bg-primary-main text-white transition-width duration-500 ease w-64 h-full overflow-y-auto overflow-x-hidden">
    <div id="sidebar-actions" class="flex justify-between items-center p-4 text-2xl">
        <div id="lang-switcher" class="flex">
            <a href="" class="hover:text-primary-light">KZ</a>
            <a href="" class="mx-2 hover:text-primary-light">RU</a>
            <a href="" class="hover:text-primary-light">EN</a>
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
            class="w-full p-3 border border-primary-light text-white placeholder-white bg-primary-main focus:outline-none focus:ring-1 focus:ring-primary-light focus:border-primary-light"
        />
        <button type="submit" class="absolute inset-y-0 right-6 flex items-center text-primary-light">
            <i class="fa fa-search"></i>
        </button>
    </form>
    <nav id="menu" class="mt-4">
        <ul class="text-xl">
            <li class="hover:bg-primary-secondary duration-300"><a class="block p-4" href="#">Главная</a></li>
            <li class="hover:bg-primary-secondary duration-300"><a class="block p-4" href="#">О вузе</a></li>
            <li class="hover:bg-primary-secondary duration-300"><a class="block p-4" href="#">Абитуриенту</a></li>
            <li class="hover:bg-primary-secondary duration-300"><a class="block p-4" href="#">Студенту</a></li>
            <li class="hover:bg-primary-secondary duration-300"><a class="block p-4" href="#">Выпускнику</a></li>
            <li class="hover:bg-primary-secondary duration-300"><a class="block p-4" href="#">Сотруднику</a></li>
        </ul>
    </nav>
</div>

<!-- Main Content -->
<div id="content" class="flex-1 bg-gray-100 p-4 transition-all duration-500 overflow-y-auto">
    <div class="">

    </div>
    @yield('content')
</div>
<script src="/assets/js/pro.min.js"></script>
@vite('resources/js/app.js')
@stack('scripts')
</body>
</html>
