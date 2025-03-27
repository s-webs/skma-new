<div class="">
    @foreach ($items as $item)
        @if ($loop->last)
            <span class="font-semibold">{{ $item['title'] }}</span>
        @else
            <span class="mr-[10px] font-semibold">
                <a href="{{ $item['url'] }}" class="text-[var(--color-main)] hover:text-[var(--color-extra)] transition-all duration-300">
                    {{ $item['title'] }}
                </a>
            </span>
            <span class="mr-[10px]">
                <i class="fal fa-angle-right text-[var(--color-main)]"></i>
            </span>
        @endif
    @endforeach
</div>
