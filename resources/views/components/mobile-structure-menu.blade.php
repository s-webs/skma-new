@props(['item', 'title' => __('public.menu')])

<div class="lg:hidden mt-[60px] rounded-[15px] overflow-hidden shadow-md">
    <div>
        <div id="toggleStructureMenu" class="bg-[var(--color-main)] px-[25px] py-[15px] cursor-pointer">
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
                        <span class="text-[var(--color-main)] font-semibold">{{ $item->getProperty('name') }}</span>
                    </div>
                    <div class="pl-[20px]">
                        @include('custom-components.mobile-divisions-list', ['divisions' => $item->children, 'currentId' => $item->id])
                    </div>
                </div>
            @endif
        </div>
    </div>
</div>
