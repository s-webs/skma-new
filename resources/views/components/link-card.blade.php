<a href="{{ $url }}"
   class="flex items-center justify-between w-full md:w-auto mb-[20px] md:mb-[0] bg-white p-[24px] rounded-[20px] group hover:bg-[var(--color-main)] transition-all duration-300 md:mr-[20px]" target="_blank">
    <div class=" md:min-w-[210px] mr-[20px]">
        <div class="group-hover:text-white transition-all duration-300">{{ $title }}</div>
        <div
            class="font-semibold group-hover:text-white transition-all duration-300 text-[var(--color-main)]">{{ $subtitle }}</div>
    </div>
    <div class="text-[var(--color-main)] text-2xl group-hover:text-white transition-all duration-300">
        <i class="fal fa-long-arrow-right"></i>
    </div>
</a>
