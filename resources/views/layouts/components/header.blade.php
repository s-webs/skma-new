<header>
    @include('layouts.components.top-header')
    {{-- MainHeader --}}
    <div class="bg-white shadow-md relative z-[5]">
        <div class="container px-4 2xl:px-[16px] mx-auto flex items-center">
            <div class="w-[104px] relative">
                <a href="{{ route('home') }}"
                   class="flex items-center justify-center bg-custom-main w-[74px] md:w-[104px] h-[70px] md:h-[100px] absolute z-10 top-[-29px] md:top-[-28px] lg:top-[-39px] left-1/2 -translate-x-1/2 lg:left-[0px] lg:translate-x-0 rounded-bl-2xl rounded-br-2xl shadow-md pb-[10px] pt-[5px] lg:pb-[20px] lg:pt-[8px]">
                    <object data="/assets/images/logos/logo.svg" type="image/svg+xml" class="w-full h-full" style="pointer-events: none;">
                        <img src="/assets/images/logos/logo.png" alt="logo">
                    </object>
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
                                <ul class="absolute z-[50] top-[100%] left-0 bg-white py-[16px] shadow-md rounded-md opacity-0 invisible group-hover:opacity-100 group-hover:visible transition-opacity duration-300 min-w-[300px] max-w-[400px]">
                                    @foreach ($menu->children as $child)
                                        <li class="my-[16px]">
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
                <button id="openSearchModal"
                    class="bg-custom-main w-[44px] h-[44px] rounded-full text-white hover:bg-[#5E18AF] transition-colors duration-300">
                    <i class="fas fa-search"></i>
                </button>
            </div>
            <div class="ml-[44px] hidden lg:block">
                @auth
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button
                           class="bg-custom-main rounded-full px-[24px] py-[12.5px] text-white font-semibold hover:bg-[#5E18AF] transition-colors duration-300">{{ __('public.logout') }}</button>
                    </form>
                @endauth

                @guest
                        <a href="{{ route('login') }}"
                           class="bg-custom-main rounded-full px-[24px] py-[12.5px] text-white font-semibold hover:bg-[#5E18AF] transition-colors duration-300">{{ __('public.sign_in') }}</a>
                @endguest
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
