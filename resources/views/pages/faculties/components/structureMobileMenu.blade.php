<div class="lg:hidden mt-[60px] rounded-[15px] overflow-hidden shadow-md">
    <div>
        <div id="toggleStructureMenu" class="bg-[var(--color-main)] px-[25px] py-[15px]">
            <div class="flex items-center justify-between text-white font-semibold">
                <span class="">{{ __('public.menu') }}</span>
                <i id="structureMenuIcon" class="fal fa-angle-right transition-all duration-300"></i>
            </div>
        </div>
        <div id="structureMenu" class="bg-white px-[25px] py-[15px]">
            @if($item->parent)
                <div>
                    <a href="{{ route('faculties.show', $item->parent->getProperty('slug')) }}"
                       class="font-semibold">
                        {{ $item->parent->getProperty('name') }}
                    </a>
                </div>
                <div class="pl-[20px]">
                    @foreach($item->parent->children as $child)
                        <div>
                            @if($child->id === $item->id)
                                <span
                                    class="text-[var(--color-main)] font-semibold">{{ $item->getProperty('name') }}
                                                </span>
                            @else
                                <a href="{{ route('faculties.show', $child->getProperty('slug')) }}"
                                   class="">{{ $child->getProperty('name') }}
                                </a>
                            @endif
                        </div>
                    @endforeach
                    @if($item->children)
                        <div class="pl-[20px]">
                            @foreach($item->children as $child)
                                <div>
                                    <a href="{{ route('faculties.show', $child->getProperty('slug')) }}"
                                       class="">{{ $child->getProperty('name') }}</a>
                                </div>
                            @endforeach
                        </div>
                    @endif
                </div>
            @else
                <div class="">
                    <div><span
                            class="text-[var(--color-main)] font-semibold">{{ $item->getProperty('name') }}</span>
                    </div>
                    @if($item->children)
                        <div class="pl-[20px]">
                            @foreach($item->children as $child)
                                <div>
                                    <a href="{{ route('faculties.show', $child->getProperty('slug')) }}"
                                       class="">{{ $child->getProperty('name') }}</a>
                                </div>
                            @endforeach
                        </div>
                    @endif
                </div>
            @endif
        </div>
    </div>
</div>
