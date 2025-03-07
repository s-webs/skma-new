<header>
    {{-- TopHeader --}}
    <div class="bg-custom-dark py-[13px] font-semibold">
        <div class="container px-4 2xl:px-[16px] mx-auto justify-between flex items-center">
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
                <button
                    class="bg-custom-main w-[44px] h-[44px] rounded-full text-white hover:bg-[#5E18AF] transition-colors duration-300">
                    <i class="fas fa-search"></i>
                </button>
            </div>
            <div class="ml-[44px] hidden lg:block">
                <a href="{{ route('login') }}"
                   class="bg-custom-main rounded-full px-[24px] py-[12.5px] text-white font-semibold hover:bg-[#5E18AF] transition-colors duration-300">Войти</a>
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
