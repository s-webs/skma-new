@props(['item', 'title' => __('public.menu')])

@if($activeTheme && $activeTheme->code === 'winter')
    <div class="lg:hidden mt-[60px] rounded-[15px] overflow-hidden shadow-md">
        <div>
            <div id="toggleStructureMenu" class="bg-winter-main px-[25px] py-[15px] cursor-pointer">
                <div class="flex items-center justify-between text-white font-semibold">
                    <span class="">{{ $title }}</span>
                    <i id="structureMenuIcon" class="fal fa-angle-right transition-all duration-300"></i>
                </div>
            </div>
            <div id="structureMenu" class="bg-white px-[25px] py-[15px] hidden">
                @if($item->parent)
                    <div>
                        <a href="{{ route('structure.show', $item->parent->getProperty('slug')) }}"
                           class="font-semibold">
                            {{ $item->parent->getProperty('name') }}
                        </a>
                    </div>
                    <div class="pl-[20px]">
                        @include('custom-components.mobile-divisions-list', ['divisions' => $item->parent->children, 'currentId' => $item->id])
                    </div>
                @else
                    <div class="">
                        <div>
                            <span class="text-winter-main font-semibold">{{ $item->getProperty('name') }}</span>
                        </div>
                        <div class="pl-[20px]">
                            @include('custom-components.mobile-divisions-list', ['divisions' => $item->children, 'currentId' => $item->id])
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </div>
@elseif($activeTheme && $activeTheme->code === 'summer')
    <div class="lg:hidden mt-[60px] rounded-[15px] overflow-hidden shadow-md">
        <div>
            <div id="toggleStructureMenu" class="bg-summer-main px-[25px] py-[15px] cursor-pointer">
                <div class="flex items-center justify-between text-white font-semibold">
                    <span class="">{{ $title }}</span>
                    <i id="structureMenuIcon" class="fal fa-angle-right transition-all duration-300"></i>
                </div>
            </div>
            <div id="structureMenu" class="bg-white px-[25px] py-[15px] hidden">
                @if($item->parent)
                    <div>
                        <a href="{{ route('structure.show', $item->parent->getProperty('slug')) }}"
                           class="font-semibold">
                            {{ $item->parent->getProperty('name') }}
                        </a>
                    </div>
                    <div class="pl-[20px]">
                        @include('custom-components.mobile-divisions-list', ['divisions' => $item->parent->children, 'currentId' => $item->id])
                    </div>
                @else
                    <div class="">
                        <div>
                            <span class="text-summer-main font-semibold">{{ $item->getProperty('name') }}</span>
                        </div>
                        <div class="pl-[20px]">
                            @include('custom-components.mobile-divisions-list', ['divisions' => $item->children, 'currentId' => $item->id])
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </div>
@elseif($activeTheme && $activeTheme->code === 'autumn')
    <div class="lg:hidden mt-[60px] rounded-[15px] overflow-hidden shadow-md">
        <div>
            <div id="toggleStructureMenu" class="bg-autumn-main px-[25px] py-[15px] cursor-pointer">
                <div class="flex items-center justify-between text-white font-semibold">
                    <span class="">{{ $title }}</span>
                    <i id="structureMenuIcon" class="fal fa-angle-right transition-all duration-300"></i>
                </div>
            </div>
            <div id="structureMenu" class="bg-white px-[25px] py-[15px] hidden">
                @if($item->parent)
                    <div>
                        <a href="{{ route('structure.show', $item->parent->getProperty('slug')) }}"
                           class="font-semibold">
                            {{ $item->parent->getProperty('name') }}
                        </a>
                    </div>
                    <div class="pl-[20px]">
                        @include('custom-components.mobile-divisions-list', ['divisions' => $item->parent->children, 'currentId' => $item->id])
                    </div>
                @else
                    <div class="">
                        <div>
                            <span class="text-autumn-main font-semibold">{{ $item->getProperty('name') }}</span>
                        </div>
                        <div class="pl-[20px]">
                            @include('custom-components.mobile-divisions-list', ['divisions' => $item->children, 'currentId' => $item->id])
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </div>
@else
    <div class="lg:hidden mt-[60px] rounded-[15px] overflow-hidden shadow-md">
        <div>
            <div id="toggleStructureMenu" class="bg-custom-main px-[25px] py-[15px] cursor-pointer">
                <div class="flex items-center justify-between text-white font-semibold">
                    <span class="">{{ $title }}</span>
                    <i id="structureMenuIcon" class="fal fa-angle-right transition-all duration-300"></i>
                </div>
            </div>
            <div id="structureMenu" class="bg-white px-[25px] py-[15px] hidden">
                @if($item->parent)
                    <div>
                        <a href="{{ route('structure.show', $item->parent->getProperty('slug')) }}"
                           class="font-semibold">
                            {{ $item->parent->getProperty('name') }}
                        </a>
                    </div>
                    <div class="pl-[20px]">
                        @include('custom-components.mobile-divisions-list', ['divisions' => $item->parent->children, 'currentId' => $item->id])
                    </div>
                @else
                    <div class="">
                        <div>
                            <span class="text-custom-main font-semibold">{{ $item->getProperty('name') }}</span>
                        </div>
                        <div class="pl-[20px]">
                            @include('custom-components.mobile-divisions-list', ['divisions' => $item->children, 'currentId' => $item->id])
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </div>
@endif
