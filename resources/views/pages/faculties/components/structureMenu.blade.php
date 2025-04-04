<div>
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
            <div>
                                        <span
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
