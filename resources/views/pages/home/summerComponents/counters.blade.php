<div class="bg-summer-main overflow-hidden">
    <div class="py-[60px] relative">
        <div class="absolute left-0 top-0 w-full h-full z-[3]">
            <img src="/assets/images/cliparts/summer_01.png" alt="" class="w-full h-full bg-blend-screen opacity-10 object-cover">
        </div>

        <div class="relative z-[5]">
            <div class="container mx-auto px-4">
                <div class="flex flex-wrap md:flex-nowrap justify-between md:justify-center items-center">
                    <div
                        class="w-[170px] md:w-[200px] h-[100px] md:h-[104px] bg-summer-extra bg-opacity-60 rounded-full flex flex-col justify-center items-center md:mr-[10px]">
                        <div class="text-white text-2xl font-semibold">9</div>
                        <div class="text-lg text-white">онлайн</div>
                    </div>
                    <div
                        class="w-[170px] md:w-[200px] h-[100px] md:h-[104px] bg-summer-extra bg-opacity-60 rounded-full flex flex-col justify-center items-center md:mr-[10px]">
                        <div class="text-white text-2xl font-semibold">703</div>
                        <div class="text-lg text-white">24 часа</div>
                    </div>
                    <div
                        class="w-[170px] md:w-[200px] h-[100px] md:h-[104px] bg-summer-extra bg-opacity-60 rounded-full flex flex-col justify-center items-center md:mr-[10px] mt-[20px] md:mt-[0px]">
                        <div class="text-white text-2xl font-semibold">57 013</div>
                        <div class="text-lg text-white">месяц</div>
                    </div>
                    <div
                        class="w-[170px] md:w-[200px] h-[100px] md:h-[104px] bg-summer-extra bg-opacity-60 rounded-full flex flex-col justify-center items-center mt-[20px] md:mt-[0px]">
                        <div class="text-white text-2xl font-semibold">3 045 156</div>
                        <div class="text-lg text-white">всего</div>
                    </div>
                </div>
            </div>
        </div>

        <div class="flex flex-wrap xl:flex-nowrap items-center justify-center mt-[60px] relative z-[5]">
            @foreach($counters as $counter)
                <div
                    class="w-[160px] h-[160px] xl:w-[250px] xl:h-[250px] m-[14px] rounded-full flex flex-col justify-center items-center text-center mx-[16px] xl:mx-[40px] p-5 text-white bg-summer-main border-[5px] bg-opacity-45 xl:border-[20px] border-summer-extra border-opacity-30">
                    <div class="text-[24px] xl:text-[44px] font-semibold">
                        <span class="counter" data-count="{{ $counter->count }}">0</span>
                    </div>
                    <div class="text-[12px] xl:text-[16px] mt-[8px]">{{ $counter->getProperty('name') }}</div>
                </div>
            @endforeach
        </div>
    </div>
</div>
