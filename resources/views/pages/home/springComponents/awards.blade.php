<div class="bg-white">
    <div class="container mx-auto px-2 xl:px-[44px] py-[50px] lg:py-[100px]">
        <div class="flex flex-col md:flex-row items-center justify-between">
            <div class="text-[24px] md:text-[36px] font-bold">
                <h3>{{ __('home.awardsAchievements') }}</h3>
            </div>
            <div class="hidden md:block">
                <a href="{{ route('awards.index') }}"
                   class="relative flex justify-between items-center mt-[20px] md:mt-[0px] bg-custom-main rounded-full overflow-hidden group transition-all duration-300 hover:shadow-lg hover:scale-105">
                    <div
                            class="text-[14px] lg:text-[18px] pl-[31px] font-semibold text-white relative z-10 transition-all duration-300">
                        {{ __('home.allAwards') }}
                    </div>
                    <div
                            class="flex items-center justify-center ml-[21px] w-[40px] md:w-[64px] h-[40px] md:h-[64px] bg-[#914EFF] text-white rounded-full relative z-10 transition-all duration-300 group-hover:bg-[#6835B8] group-hover:scale-110">
                        <i class="fal fa-arrow-right text-[20px]"></i>
                    </div>
                </a>
            </div>
        </div>
        <div class="flex 2xl:flex-nowrap flex-wrap items-center justify-between mt-[30px] 2xl:mt-[60px]">
            @foreach($awards as $item)
                <div class="my-[16px] md:my-[15px] w-[48%] 2xl:w-[24%] 2xl:h-[auto] 2xl:my-[0px]">
                    <img src="{{ $item->getProperty('image') }}" alt="{{ $item->getProperty('image') }}"
                         class="w-full h-full object-cover">
{{--                    <div class="font-semibold text-[14px] mt-[8px] text-center">--}}
{{--                        {{ $item->getProperty('name') }}--}}
{{--                    </div>--}}
                </div>
            @endforeach
        </div>
        <div class="md:hidden max-w-[80%]">
            <a href="{{ route('awards.index') }}"
               class="relative flex justify-between items-center mt-[20px] md:mt-[0px] bg-custom-main rounded-full overflow-hidden group transition-all duration-300 hover:shadow-lg hover:scale-105">
                <div
                    class="text-[14px] lg:text-[18px] pl-[31px] font-semibold text-white relative z-10 transition-all duration-300">
                    {{ __('home.allAwards') }}
                </div>
                <div
                    class="flex items-center justify-center ml-[21px] w-[40px] md:w-[64px] h-[40px] md:h-[64px] bg-[#914EFF] text-white rounded-full relative z-10 transition-all duration-300 group-hover:bg-[#6835B8] group-hover:scale-110">
                    <i class="fal fa-arrow-right text-[20px]"></i>
                </div>
            </a>
        </div>
    </div>
</div>
