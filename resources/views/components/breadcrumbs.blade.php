<div class="">
    @foreach ($items as $item)
        @if ($loop->last)
            <span class="font-semibold">{{ $item['title'] }}</span>
        @else
            <span class="mr-[10px] font-semibold">
                <a href="{{ $item['url'] }}" class="text-custom-main hover:text-[#5E18AF] transition-all duration-300">
                    {{ $item['title'] }}
                </a>
            </span>
            <span class="mr-[10px]">
                <i class="fal fa-angle-right text-custom-main"></i>
            </span>
        @endif
    @endforeach
</div>
