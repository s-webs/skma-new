<div class="mt-[60px]">
    <h3 class="text-md lg:text-xl font-semibold border-b pb-[10px]">{{ $title }} (найдено: {{ count($results) }})</h3>
    <div class="mt-[30px]">
        @if(count($results) > 0)
        @foreach($results as $item)
            <div class="mb-[20px]">
                @if($activeTheme->code === 'winter')
                    <a href="{{ route($route, $item->getProperty('slug')) }}"
                       class="hover:text-winter-main transition-all duration-300">
                        {{ $item->getProperty($field) }}
                    </a>
                @elseif($activeTheme->code === 'summer')
                    <a href="{{ route($route, $item->getProperty('slug')) }}"
                       class="hover:text-summer-main transition-all duration-300">
                        {{ $item->getProperty($field) }}
                    </a>
                @else
                    <a href="{{ route($route, $item->getProperty('slug')) }}"
                       class="hover:text-custom-main transition-all duration-300">
                        {{ $item->getProperty($field) }}
                    </a>
                @endif
            </div>
        @endforeach
        @else
            <div>
                Ничего не найдено
            </div>
        @endif
    </div>
</div>
