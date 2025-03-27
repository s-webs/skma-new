<div class="bg-[var(--color-main)] overflow-hidden">
    <div class="py-[60px] relative">
        @if($activeTheme->pattern_01)
            <div class="absolute hidden md:block left-[3%] uxl:left-[25%] bottom-[0px]">
                <img src="/{{ $activeTheme->pattern_01 }}" alt="" class="w-[120px] xl:w-auto">
            </div>
        @endif

        @if($activeTheme->pattern_02)
            @if($activeTheme->code === 'default')
                <div class="absolute right-[0px] bottom-[0px] z-[3]">
                    <img src="/assets/images/cliparts/wave.png" alt="" class="w-auto h-[150px] xl:h-auto">
                </div>
            @else
                <div class="absolute right-[0px] bottom-[0px] z-[3] h-full w-full">
                    <img src="/{{ $activeTheme->pattern_02 }}" alt=""
                         class="w-full h-full md:h-[150px] 2xl:h-auto opacity-20 object-cover">
                </div>
            @endif
        @endif

        <div>
            <div class="container mx-auto px-4 relative z-[5]">
                <div class="flex flex-wrap md:flex-nowrap justify-between md:justify-center items-center">
                    <div
                        class="w-[170px] md:w-[200px] h-[100px] md:h-[104px] bg-white bg-opacity-30 rounded-full flex flex-col justify-center items-center md:mr-[10px]">
                        <div class="text-white text-2xl font-semibold">9</div>
                        <div class="text-lg text-white">онлайн</div>
                    </div>
                    <div
                        class="w-[170px] md:w-[200px] h-[100px] md:h-[104px] bg-white bg-opacity-30 rounded-full flex flex-col justify-center items-center md:mr-[10px]">
                        <div class="text-white text-2xl font-semibold">703</div>
                        <div class="text-lg text-white">24 часа</div>
                    </div>
                    <div
                        class="w-[170px] md:w-[200px] h-[100px] md:h-[104px] bg-white bg-opacity-30 rounded-full flex flex-col justify-center items-center md:mr-[10px] mt-[20px] md:mt-[0px]">
                        <div class="text-white text-2xl font-semibold">57 013</div>
                        <div class="text-lg text-white">месяц</div>
                    </div>
                    <div
                        class="w-[170px] md:w-[200px] h-[100px] md:h-[104px] bg-white bg-opacity-30 rounded-full flex flex-col justify-center items-center mt-[20px] md:mt-[0px]">
                        <div class="text-white text-2xl font-semibold">3 045 156</div>
                        <div class="text-lg text-white">всего</div>
                    </div>
                </div>
            </div>
        </div>

        <div class="flex flex-wrap xl:flex-nowrap items-center justify-center mt-[60px] relative z-[5]">
            @foreach($counters as $counter)
                <div
                    class="w-[160px] h-[160px] xl:w-[250px] xl:h-[250px] m-[14px] rounded-full flex flex-col justify-center items-center text-center mx-[16px] xl:mx-[40px] p-5 text-white bg-white bg-opacity-30 border-[5px] xl:border-[20px] border-white border-opacity-20">
                    <div class="text-[24px] xl:text-[44px] font-semibold">
                        <span class="counter" data-count="{{ $counter->count }}">0</span>
                    </div>
                    <div class="text-[12px] xl:text-[16px] mt-[8px]">{{ $counter->getProperty('name') }}</div>
                </div>
            @endforeach
        </div>
    </div>
</div>
