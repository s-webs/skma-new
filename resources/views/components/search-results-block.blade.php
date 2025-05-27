<div class="mt-[60px]">
    <h3 class="text-md lg:text-xl font-semibold border-b pb-[10px]">{{ $title }} (найдено: {{ count($results) }})</h3>
    <div class="mt-[30px]">
        @if(count($results) > 0)
            @foreach($results as $item)
                <div class="mb-[20px]">
                    <a href="{{ route($route, [app()->getLocale(), $item->getProperty('slug')]) }}"
                       class="hover:text-[var(--color-main)] transition-all duration-300">
                        {{ $item->getProperty($field) }}
                    </a>
                </div>
            @endforeach
        @else
            <div>
                Ничего не найдено
            </div>
        @endif
    </div>
</div>
