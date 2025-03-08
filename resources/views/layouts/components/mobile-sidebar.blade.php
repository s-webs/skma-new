<div id="sidebarMobile"
     class="lg:hidden flex flex-col h-[100vh] w-[100%] fixed bg-custom-halftone z-20 -translate-x-full transition-transform duration-300">
    <div class="flex justify-end px-[16px] bg-custom-heading text-white py-[8px]">
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
    <div class="px-2 mt-[16px]">
        <a href="{{ route('login') }}" class="block bg-custom-main rounded-full px-[24px] py-[8px] text-white font-semibold hover:bg-[#5E18AF] transition-colors duration-300">Войти</a>
    </div>
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
    <div class="text-center bg-custom-heading py-[22px]">
        <div class="text-white text-[16px]">
            <a href="tel:87252573535" class="mr-[22px]">
                <i class="fas fa-phone-alt mr-[7.69px]"></i>8 7252 57 35 35
            </a>
            <a href="mailto:info@skma.kz">
                <i class="fas fa-envelope-open mr-[7.69px]"></i>info@skma.kz
            </a>
        </div>
    </div>
    {{-- /MobileSidebarFooter --}}
</div>
