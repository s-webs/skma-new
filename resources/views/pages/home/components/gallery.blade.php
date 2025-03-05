<div class="bg-white">
    <div class="container mx-auto px-2 xl:px-[44px] py-[50px] xl:py-[100px]">
        <div class="flex flex-col md:flex-row items-center justify-between">
            <div class="text-[24px] md:text-[36px] font-bold">
                <h3>{{ __('home.academyGallery') }}</h3>
            </div>
            <div class="hidden md:block">
                <a href="##"
                   class="relative flex justify-between items-center mt-[20px] md:mt-[0px] bg-custom-main rounded-full overflow-hidden group transition-all duration-300 hover:shadow-lg hover:scale-105">
                    <div
                        class="text-[14px] lg:text-[18px] pl-[31px] font-semibold text-white relative z-10 transition-all duration-300">
                        {{ __('home.allPhoto') }}
                    </div>
                    <div
                        class="flex items-center justify-center ml-[21px] w-[40px] md:w-[64px] h-[40px] md:h-[64px] bg-[#914EFF] text-white rounded-full relative z-10 transition-all duration-300 group-hover:bg-[#6835B8] group-hover:scale-110">
                        <i class="fal fa-arrow-right text-[20px]"></i>
                    </div>
                </a>
            </div>
        </div>
        <div class="hidden xl:block">
            <div class="swiper gallery-slider mt-[60px]">
                <div class="swiper-wrapper">
                    @foreach($gallery as $item)
                        <div class="swiper-slide">
                            <img src="{{ $item->image }}" alt="{{ $item->image }}" class="w-auto h-[300px] object-cover rounded-[20px]">
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
        <div class="hidden md:block xl:hidden">
            <div class="swiper gallery-md-slider mt-[60px]">
                <div class="swiper-wrapper">
                    @foreach($gallery as $item)
                        <div class="swiper-slide">
                            <img src="{{ $item->image }}" alt="{{ $item->image }}" class="h-[200px] object-cover rounded-[20px]">
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
        <div class="md:hidden">
            <div class="swiper gallery-sm-slider mt-[30px]">
                <div class="swiper-wrapper">
                    @foreach($gallery as $item)
                        <div class="swiper-slide">
                            <img src="{{ $item->image }}" alt="{{ $item->image }}" class="h-[200px] object-cover rounded-[20px]">
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
        <div class="md:hidden max-w-[80%]">
            <a href="##"
               class="relative flex justify-between items-center mt-[20px] md:mt-[0px] bg-custom-main rounded-full overflow-hidden group transition-all duration-300 hover:shadow-lg hover:scale-105">
                <div
                    class="text-[14px] lg:text-[18px] pl-[31px] font-semibold text-white relative z-10 transition-all duration-300">
                    {{ __('home.allPhoto') }}
                </div>
                <div
                    class="flex items-center justify-center ml-[21px] w-[40px] md:w-[64px] h-[40px] md:h-[64px] bg-[#914EFF] text-white rounded-full relative z-10 transition-all duration-300 group-hover:bg-[#6835B8] group-hover:scale-110">
                    <i class="fal fa-arrow-right text-[20px]"></i>
                </div>
            </a>
        </div>
    </div>
</div>
