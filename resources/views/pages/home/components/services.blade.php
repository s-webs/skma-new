<div class="bg-white">
    <div class="container mx-auto px-2 xl:px-[44px] py-[50px] xl:py-[100px]">
        <div class="flex flex-col md:flex-row items-center justify-between">
            <div class="text-[24px] md:text-[36px] font-bold">
                <h3>{{ __('home.academyServices') }}</h3>
            </div>
            <div class="hidden md:block">
                <div class="flex items-center">
                    <button id="services-prev"
                            class="border flex justify-center items-center border-[#E2E2E2] w-[35px] xl:w-[64px] h-[35px] xl:h-[64px] rounded-full text-[16px] xl:text-[30px] text-white hover:text-[var(--color-main)] mr-[12px] bg-[var(--color-main)] hover:bg-[var(--color-halftone)] transition-colors duration-300">
                        <i class="fas fa-angle-left translate-y-[1px]"></i>
                    </button>
                    <button id="services-next"
                            class="border flex justify-center items-center border-[#E2E2E2] w-[35px] xl:w-[64px] h-[35px] xl:h-[64px] rounded-full text-[16px] xl:text-[30px] text-white hover:text-[var(--color-main)] bg-[var(--color-main)] hover:bg-[var(--color-halftone)] transition-colors duration-300">
                        <i class="fas fa-angle-right translate-y-[1px]"></i>
                    </button>
                </div>
            </div>
        </div>
        <div class="swiper-container">
            <div class="hidden xl:block">
                <div class="swiper slider-services mt-[60px]">
                    <div class="swiper-wrapper">
                        @foreach($services as $item)
                            <div class="swiper-slide w-[400px] max-h-[300px] rounded-[20px] overflow-hidden relative group transition-all duration-300">
                                <img src="{{ $item->getProperty('image') }}" alt="{{ $item->getProperty('name') }}"
                                     class="w-full h-full object-cover group-hover:scale-105 transition-all duration-300">
                                <div class=" absolute bottom-[20px] left-[20px] z-[5]">
                                    <a href="{{ $item->getProperty('link') }}" class="text-[24px] font-semibold flex items-center text-white">
                                        <span>{{ $item->getProperty('name') }}</span> <i class="ml-[10px] fal fa-long-arrow-right translate-y-[4px] group-hover:translate-x-[10px] transition-all duration-300"></i>
                                    </a>
                                </div>
                                <div
                                    class="absolute bottom-[0] left-[0] w-full h-[120px] group-hover:h-[180px] bg-gradient-to-t from-[var(--color-main)] to-white/0 transition-all duration-300 z-[3]">
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
            <div class="hidden md:block xl:hidden">
                <div class="swiper slider-md-services mt-[60px]">
                    <div class="swiper-wrapper">
                        @foreach($services as $item)
                            <div class="swiper-slide w-[400px] max-h-[200px] rounded-[20px] overflow-hidden relative">
                                <img src="{{ $item->getProperty('image') }}" alt="{{ $item->getProperty('name') }}"
                                     class="w-full h-full object-cover">
                                <div class=" absolute bottom-[20px] left-[20px] z-[5]">
                                    <a href="{{ $item->getProperty('link') }}" class="text-[14px] font-semibold flex items-center text-white">
                                        <span>{{ $item->getProperty('name') }}</span> <i class="ml-[10px] fal fa-long-arrow-right translate-y-[2px] group-hover:translate-x-[10px] transition-all duration-300"></i>
                                    </a>
                                </div>
                                <div
                                    class="absolute bottom-[0] left-[0] w-full h-[120px] bg-gradient-to-t from-[var(--color-main)] to-white/0">
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
            <div class="md:hidden">
            <div class="swiper slider-sm-services mt-[60px]">
                <div class="swiper-wrapper">
                    @foreach($services as $item)
                        <div class="swiper-slide w-[400px] max-h-[200px] rounded-[20px] overflow-hidden relative">
                            <img src="{{ $item->getProperty('image') }}" alt="{{ $item->getProperty('name') }}"
                                 class="w-full h-full object-cover">
                            <div class=" absolute bottom-[20px] left-[20px] z-[5]">
                                <a href="{{ $item->getProperty('link') }}" class="text-[14px] font-semibold flex items-center text-white">
                                    <span>{{ $item->getProperty('name') }}</span> <i class="ml-[10px] fal fa-long-arrow-right translate-y-[2px] group-hover:translate-x-[10px] transition-all duration-300"></i>
                                </a>
                            </div>
                            <div
                                class="absolute bottom-[0] left-[0] w-full h-[120px] bg-gradient-to-t from-[var(--color-main)] to-white/0">
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
            </div>
        </div>
    </div>
</div>
