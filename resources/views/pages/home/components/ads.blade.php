<div>
    <div class="container mx-auto px-2 xl:px-[44px] py-[50px] lg:py-[100px]">
        <div class="flex flex-col md:flex-row items-center justify-between">
            <div class="text-[24px] md:text-[36px] font-bold">
                <h3>{{ __('home.academyAnnouncement') }}</h3>
            </div>
            <div class="hidden md:block">
                <a href="{{ route('ads.index') }}"
                   class="relative flex justify-between items-center mt-[20px] md:mt-[0px] bg-custom-main rounded-full overflow-hidden group transition-all duration-300 hover:shadow-lg hover:scale-105">
                    <div
                        class="text-[14px] lg:text-[18px] pl-[31px] font-semibold text-white relative z-10 transition-all duration-300">
                        {{ __('home.allAdverts') }}
                    </div>
                    <div
                        class="flex items-center justify-center ml-[21px] w-[40px] md:w-[64px] h-[40px] md:h-[64px] bg-[#914EFF] text-white rounded-full relative z-10 transition-all duration-300 group-hover:bg-[#6835B8] group-hover:scale-110">
                        <i class="fal fa-arrow-right text-[20px]"></i>
                    </div>
                </a>
            </div>
        </div>
        <div class="flex flex-col lg:flex-row items-start mt-[30px] md:mt-[60px]">
            @foreach($adverts as $item)
                <div
                    class="bg-white hover:bg-custom-main group transition-colors duration-300 p-[20px] rounded-[20px] w-full lg:w-1/3 lg:mx-[5px] text-[14px] my-[8px] lg-my-[0px]">
                    <div class="flex items-center mb-[10px]">
                        <i class="fad fa-calendar-alt text-custom-main mr-[8px] group-hover:text-white"></i>
                        <span class="group-hover:text-white">{{ $item->formatted_date }}</span>
                    </div>
                    <div class="flex items-center h-[100px] overflow-hidden font-semibold">
                        <a href="{{ route('ads.show', $item->getProperty('slug')) }}" class="group-hover:text-white">
                            {{ $item->getProperty('title') }}
                        </a>
                    </div>
                </div>
            @endforeach
        </div>
        <div class="md:hidden max-w-[80%]">
            <a href="##"
               class="relative flex justify-between items-center mt-[20px] md:mt-[0px] bg-custom-main rounded-full overflow-hidden group transition-all duration-300 hover:shadow-lg hover:scale-105">
                <div
                    class="text-[14px] lg:text-[18px] pl-[31px] font-semibold text-white relative z-10 transition-all duration-300">
                    {{ __('home.allAdverts') }}
                </div>
                <div
                    class="flex items-center justify-center ml-[21px] w-[40px] md:w-[64px] h-[40px] md:h-[64px] bg-[#914EFF] text-white rounded-full relative z-10 transition-all duration-300 group-hover:bg-[#6835B8] group-hover:scale-110">
                    <i class="fal fa-arrow-right text-[20px]"></i>
                </div>
            </a>
        </div>
    </div>
</div>
