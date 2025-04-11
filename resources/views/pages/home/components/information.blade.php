<div class="relative bg-[var(--color-main)] 2xl:h-[355px]">
    @if($activeTheme->code === 'default')
        <img src="/assets/images/cliparts/wave-02.png" alt="" class="absolute w-full h-full object-cover z-[3]">
    @else
        <img src="/{{ $activeTheme->pattern_02 }}" alt="" class="absolute w-full h-full object-cover z-[3] opacity-20">
    @endif
    <div class="container mx-auto px-2 2xl:px-[300px] relative z-[5]">
        <div class="flex items-center justify-center">
            <div class="py-[16px] md:py-[0px]">
                <div class="text-[14px] md:text-[24px] mr-[60px] 2xl:text-[36px] text-white font-bold">
                    <h3>
                        Комплаенс служба
                    </h3>
                </div>
                <div class="mt-[16px] md:mt-[32px] 2xl:mt-[64px]">
                    <a href="{{ route('komplaens.show') }}"
                       class="px-[16px] md:px-[31px] py-[8px] md:py-[21px] bg-white hover:bg-[var(--color-main)] text-[12px] md:text-[18px] font-semibold text-[var(--color-main)] hover:text-white transition-all duration-300 rounded-full">{{ __('home.detail') }}</a>
                </div>
            </div>
            <div class="w-[150px] h-[150px] md:w-[300px] md:h-[300px] 2xl:w-[400px] 2xl:h-[400px] border-[10px] md:border-[20px] 2xl:-translate-y-[20px] border-[var(--color-extra)] rounded-[10px] overflow-hidden bg-[var(--color-extra)]">
                <img src="/assets/images/komplaens_01.jpg" alt="" class="w-full h-full object-cover rounded-[10px]">
            </div>
        </div>
    </div>
</div>
