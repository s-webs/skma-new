@if($divisions->isNotEmpty())
    @foreach($divisions as $division)
        <div class="">
            @if($division->id === $currentId)
                @if($division->children->isNotEmpty())
                    <div class="flex items-center justify-between text-custom-main font-semibold">
                        <span class="">{{ $division->getProperty('name') }}</span>
                        <span class="cursor-pointer toggle-mobile-division" data-id="{{ $division->id }}">
                            <i class="fas fa-chevron-down"></i>
                        </span>
                    </div>

                    <div id="mobile-children-{{ $division->id }}" class="pl-[20px]">
                        @include('custom-components.mobile-divisions-list', ['divisions' => $division->children, 'currentId' => $currentId])
                    </div>
                @else
                    <span class="text-custom-main font-semibold flex-1">
                    {{ $division->getProperty('name') }}
                </span>
                @endif
            @else
                <div>

                </div>
                <div class="flex-1 flex items-center justify-between">
                    <a href="{{ route('structure.show', $division->getProperty('slug')) }}">
                        {{ $division->getProperty('name') }}
                    </a>
                    @if($division->children->isNotEmpty())
                        <span class="cursor-pointer toggle-mobile-division" data-id="{{ $division->id }}">
                            <i class="fas fa-chevron-down"></i>
                        </span>
                    @endif
                </div>
                <div id="mobile-children-{{ $division->id }}" class="pl-[20px] hidden">
                    @if($division->children->isNotEmpty())
                        @include('custom-components.mobile-divisions-list', ['divisions' => $division->children, 'currentId' => $currentId])
                    @endif
                </div>
            @endif
        </div>
    @endforeach
@endif
