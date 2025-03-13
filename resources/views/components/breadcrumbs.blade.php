@if($activeTheme && $activeTheme->code === 'winter')
    <div class="">
        @foreach ($items as $item)
            @if ($loop->last)
                <span class="font-semibold">{{ $item['title'] }}</span>
            @else
                <span class="mr-[10px] font-semibold">
                <a href="{{ $item['url'] }}" class="text-winter-main hover:text-winter-extra transition-all duration-300">
                    {{ $item['title'] }}
                </a>
            </span>
                <span class="mr-[10px]">
                <i class="fal fa-angle-right text-winter-main"></i>
            </span>
            @endif
        @endforeach
    </div>
@elseif($activeTheme && $activeTheme->code === 'summer')
    <div class="">
        @foreach ($items as $item)
            @if ($loop->last)
                <span class="font-semibold">{{ $item['title'] }}</span>
            @else
                <span class="mr-[10px] font-semibold">
                <a href="{{ $item['url'] }}" class="text-summer-main hover:text-summer-extra transition-all duration-300">
                    {{ $item['title'] }}
                </a>
            </span>
                <span class="mr-[10px]">
                <i class="fal fa-angle-right text-summer-main"></i>
            </span>
            @endif
        @endforeach
    </div>
@elseif($activeTheme && $activeTheme->code === 'autumn')
    <div class="">
        @foreach ($items as $item)
            @if ($loop->last)
                <span class="font-semibold">{{ $item['title'] }}</span>
            @else
                <span class="mr-[10px] font-semibold">
                <a href="{{ $item['url'] }}" class="text-autumn-main hover:text-autumn-extra transition-all duration-300">
                    {{ $item['title'] }}
                </a>
            </span>
                <span class="mr-[10px]">
                <i class="fal fa-angle-right text-autumn-main"></i>
            </span>
            @endif
        @endforeach
    </div>
@else
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
@endif
