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
    @stack('styles')
    <title>SKMA</title>
</head>
<body class="bg-custom-halftone font-openSans">

{{-- Mobile Sidebar --}}
<div id="sidebarMobile"
     class="lg:hidden flex flex-col h-[100vh] w-[100%] fixed bg-custom-halftone z-20 -translate-x-full transition-transform duration-300">
    <div class="flex justify-end px-[16px] bg-custom-main text-white py-[8px]">
        <button class="text-[24px]" id="closeMobileSidebar"><i class="fas fa-times"></i></button>
    </div>
    {{-- MobileSearch --}}
    <div class="mt-[16px] px-2" x-data="formSearch">
        <form @submit.prevent class="bg-white text-custom-secondary border border-custom-secondary rounded-full">
            <label for="mobileSearch" class="block w-full relative px-[40px]">
                <button @click="$el.closest('form').submit()" type="button" class="absolute left-[16px] top-[8px]">
                    <i class="fas fa-search"></i>
                </button>
                <input id="mobileSearch" type="text" x-model="searchQuery"
                       @keydown.enter="$el.closest('form').submit()"
                       class="w-full border-none outline-none bg-transparent shadow-none focus:outline-none focus:ring-0">
                <button @click="resetForm(); $el.focus()" type="button" class="absolute right-[16px] top-[8px]">
                    <i class="fas fa-times-circle"></i>
                </button>
            </label>
        </form>
    </div>
    {{-- /MobileSearch --}}
    <div class="my-[24px] px-[16px]">
        <span class="block h-[1px] bg-custom-secondary"></span>
    </div>
    {{-- MobileMenu --}}
    <div class="flex-1 overflow-y-auto">
        <nav id="menu">
            <ul class="text-md px-4" x-data="{ openMenu: null }">
                @foreach ($menus as $menu)
                    <li class="relative">
                        @if ($menu->children->isNotEmpty())
                            <div
                                class="flex items-center justify-between mb-[16px] py-2 px-4 bg-custom-halftone hover:bg-custom-main text-custom-secondary hover:text-white border border-custom-secondary rounded-full transition-colors duration-300 cursor-pointer"
                                @click="openMenu === {{ $loop->index }} ? openMenu = null : openMenu = {{ $loop->index }}">
                    <span>
                        {!! $menu->icon !!}<span class="ml-4">{{ $menu->getProperty('name') }}</span>
                    </span>
                                <i class="far fa-chevron-right transition-transform duration-300"
                                   :class="{ 'rotate-90': openMenu === {{ $loop->index }} }"></i>
                            </div>
                            <ul class="pl-4 overflow-hidden transition-all duration-300"
                                :style="'max-height: ' + (openMenu === {{ $loop->index }} ? $el.scrollHeight + 'px' : '0px')">
                                @foreach ($menu->children as $child)
                                    <li class="mb-[16px]">
                                        <a href="{{ $child->getProperty('link') }}"
                                           class="block py-2 px-[16px] bg-custom-halftone hover:bg-custom-main text-custom-secondary hover:text-white border border-custom-secondary rounded-full transition-colors duration-300">
                                            {!! $child->icon !!}<span
                                                class="ml-4">{{ $child->getProperty('name') }}</span>
                                        </a>
                                    </li>
                                @endforeach
                            </ul>
                        @else
                            <a class="block mb-[16px] py-2 px-4 bg-custom-halftone hover:bg-custom-main text-custom-secondary hover:text-white border border-custom-secondary rounded-full transition-colors duration-300"
                               href="{{ $menu->getProperty('link') }}">
                                {!! $menu->icon !!}<span class="ml-4">{{ $menu->getProperty('name') }}</span>
                            </a>
                        @endif
                    </li>
                @endforeach
            </ul>
        </nav>
    </div>
    {{-- /MobileMenu --}}
    {{-- MobileSidebarFooter --}}
    <div class="text-center bg-custom-main py-[22px]">
        <div class="text-white text-[16px]">
            <a href="##" class="mr-[22px]">
                <i class="fas fa-phone-alt mr-[7.69px]"></i>+7 7252 57 35 35
            </a>
            <a href="mailto:info@skma.kz">
                <i class="fas fa-envelope-open mr-[7.69px]"></i>info@skma.kz
            </a>
        </div>
    </div>
    {{-- /MobileSidebarFooter --}}
</div>
{{-- /Mobile Sidebar --}}

{{-- Header --}}
<header>
    {{-- TopHeader --}}
    <div class="bg-custom-dark py-[13px] font-semibold">
        <div class="container px-4 2xl:px-0 mx-auto justify-between flex items-center">
            <div class="flex items-center text-[18px] text-white lg:mr-[44px]">
                <a href="##"><i class="fab fa-facebook"></i></a>
                <a href="##" class="mx-[16px]"><i class="fab fa-instagram"></i></a>
                <a href="##"><i class="fab fa-youtube"></i></a>
            </div>
            <div class="text-white text-[16px] hidden lg:block">
                <a href="##" class="mr-[22px]">
                    <i class="fas fa-phone-alt mr-[7.69px]"></i>+7 700 000 00 00
                </a>
                <a href="##">
                    <i class="fas fa-envelope-open mr-[7.69px]"></i>info@skma.kz
                </a>
            </div>
            <div class="flex-1"></div>
            <div>
                <button id="enable-pc-impaired" class="text-white flex items-center">
                    <i class="fas fa-eye mr-[6.75px]"></i>
                    <span class="hidden md:block">Версия для слабовидящих</span>
                </button>
            </div>
            <div class="text-white ml-[16px] md:ml-[44px]">
                <a href="/kz{{$kzLink ? '/' . $kzLink : ''}}{{$page ?? ''}}">ҚАЗ</a>
                <a href="/ru{{$ruLink ? '/' . $ruLink : ''}}{{$page ?? ''}}" class="mx-[16px]">РУС</a>
                <a href="/en{{$enLink ? '/' . $enLink : ''}}{{$page ?? ''}}">ENG</a>
            </div>
        </div>
    </div>
    {{-- /TopHeader --}}
    {{-- MainHeader --}}
    <div class="bg-white shadow-md relative z-[5]">
        <div class="container px-4 2xl:px-0 mx-auto flex items-center">
            <div class="w-[104px] relative">
                <a href="{{ route('home') }}"
                   class="flex items-center justify-center bg-custom-main w-[74px] md:w-[104px] h-[70px] md:h-[100px] absolute z-10 top-[-29px] md:top-[-28px] lg:top-[-39px] left-1/2 -translate-x-1/2 lg:left-[0px] lg:translate-x-0 rounded-bl-2xl rounded-br-2xl shadow-md">
                    <img src="/assets/images/logos/logo.svg" alt="logo" class="w-[36px] md:w-[48px]">
                </a>
            </div>
            <div class="flex-1"></div>
            <div class="mr-[44px] hidden lg:block">
                <ul class="flex py-[26.5px] font-semibold text-[16px]">
                    @foreach ($menus as $menu)
                        @if ($menu->children->isNotEmpty())
                            <li class="relative mx-[22px] group">
                                <span class="hover:text-custom-main transition-colors duration-300">{{ $menu->getProperty('name') }} <i
                                        class="fas fa-angle-down"></i></span>
                                <ul class="absolute top-[100%] left-0 bg-white py-[16px] shadow-md rounded-md opacity-0 invisible group-hover:opacity-100 group-hover:visible transition-opacity duration-300 min-w-[200px]">
                                    @foreach ($menu->children as $child)
                                        <li class="my-[16px] whitespace-nowrap">
                                            <a href="{{ $child->getProperty('link') }}"
                                               class="px-[16px] py-[6px] block hover:bg-custom-halftone hover:text-custom-main transition-colors duration-300">{{ $child->getProperty('name') }}</a>
                                        </li>
                                    @endforeach
                                </ul>
                            </li>
                        @else
                            <li class="mx-[22px]">
                                <a href="{{ $menu->getProperty('link') }}"
                                   class="hover:text-custom-main transition-colors duration-300">{{ $menu->getProperty('name') }}</a>
                            </li>
                        @endif
                    @endforeach
                </ul>
            </div>
            <div class="hidden lg:block">
                <button class="bg-custom-main w-[44px] h-[44px] rounded-full text-white">
                    <i class="fas fa-search"></i>
                </button>
            </div>
            <div class="block lg:hidden py-[10px]">
                <button id="openMobileSidebar" class="text-[24px]">
                    <i class="fas fa-bars"></i>
                </button>
            </div>
        </div>
    </div>
    {{-- /MainHeader --}}
</header>
{{-- /Header --}}

@yield('content')

{{-- Footer --}}
<footer class="mt-[44px]">
    <div class="bg-custom-dark py-[16px]">
        <div class="text-center">SKMA 2025</div>
    </div>
</footer>
{{-- /Footer --}}
</body>
<script src="/assets/js/pro.min.js"></script>
<script src="/assets/js/bvi.min.js"></script>
@vite('resources/js/app.js')
@stack('scripts')
</body>
</html>
