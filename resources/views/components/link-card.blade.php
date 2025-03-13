@if($activeTheme && $activeTheme->code === 'winter')
    <a href="{{ $url }}" class="flex items-center justify-between w-full md:w-auto mb-[20px] md:mb-[0] bg-white p-[24px] rounded-[20px] group hover:bg-winter-main transition-all duration-300 md:mr-[20px]">
        <div class=" md:min-w-[210px] mr-[20px]">
            <div class="group-hover:text-white transition-all duration-300">{{ $title }}</div>
            <div class="font-semibold group-hover:text-white transition-all duration-300 text-winter-main">{{ $subtitle }}</div>
        </div>
        <div class="text-winter-main text-2xl group-hover:text-white transition-all duration-300">
            <i class="fal fa-long-arrow-right"></i>
        </div>
    </a>
@elseif($activeTheme && $activeTheme->code === 'summer')
    <a href="{{ $url }}" class="flex items-center justify-between w-full md:w-auto mb-[20px] md:mb-[0] bg-white p-[24px] rounded-[20px] group hover:bg-summer-main transition-all duration-300 md:mr-[20px]">
        <div class=" md:min-w-[210px] mr-[20px]">
            <div class="group-hover:text-white transition-all duration-300">{{ $title }}</div>
            <div class="font-semibold group-hover:text-white transition-all duration-300 text-summer-main">{{ $subtitle }}</div>
        </div>
        <div class="text-summer-main text-2xl group-hover:text-white transition-all duration-300">
            <i class="fal fa-long-arrow-right"></i>
        </div>
    </a>
@elseif($activeTheme && $activeTheme->code === 'autumn')
    <a href="{{ $url }}" class="flex items-center justify-between w-full md:w-auto mb-[20px] md:mb-[0] bg-white p-[24px] rounded-[20px] group hover:bg-autumn-main transition-all duration-300 md:mr-[20px]">
        <div class=" md:min-w-[210px] mr-[20px]">
            <div class="group-hover:text-white transition-all duration-300">{{ $title }}</div>
            <div class="font-semibold group-hover:text-white transition-all duration-300 text-autumn-main">{{ $subtitle }}</div>
        </div>
        <div class="text-autumn-main text-2xl group-hover:text-white transition-all duration-300">
            <i class="fal fa-long-arrow-right"></i>
        </div>
    </a>
@else
    <a href="{{ $url }}" class="flex items-center justify-between w-full md:w-auto mb-[20px] md:mb-[0] bg-white p-[24px] rounded-[20px] group hover:bg-custom-main transition-all duration-300 md:mr-[20px]">
        <div class=" md:min-w-[210px] mr-[20px]">
            <div class="group-hover:text-white transition-all duration-300">{{ $title }}</div>
            <div class="font-semibold group-hover:text-white transition-all duration-300 text-custom-main">{{ $subtitle }}</div>
        </div>
        <div class="text-custom-main text-2xl group-hover:text-white transition-all duration-300">
            <i class="fal fa-long-arrow-right"></i>
        </div>
    </a>
@endif
