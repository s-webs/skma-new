<div class="bg-custom-main overflow-hidden">
    <div class="py-[60px] flex flex-wrap xl:flex-nowrap items-center justify-center relative">
        <div class="absolute hidden md:block left-[3%] uxl:left-[25%] bottom-[0px]">
            <img src="/assets/images/cliparts/globus.png" alt="" class="w-[120px] xl:w-auto">
        </div>

        <div class="absolute right-[0px] bottom-[0px]">
            <img src="/assets/images/cliparts/wave.png" alt="" class="w-auto h-[150px] xl:h-auto">
        </div>

        @foreach($counters as $counter)
            <div class="w-[160px] h-[160px] xl:w-[250px] xl:h-[250px] m-[14px] rounded-full flex flex-col justify-center items-center text-center mx-[16px] xl:mx-[40px] p-5 text-white bg-[#914EFF] border-[5px] xl:border-[20px] border-[#9757FF]">
                <div class="text-[24px] xl:text-[44px] font-semibold">
                    <span class="counter" data-count="{{ $counter->count }}">0</span>
                </div>
                <div class="text-[12px] xl:text-[16px] mt-[8px]">{{ $counter->getProperty('name') }}</div>
            </div>
        @endforeach
    </div>
</div>
