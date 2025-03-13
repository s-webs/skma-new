<div>
    <div class="container mx-auto px-2 xl:px-[44px] py-[50px] lg:py-[100px]">
        <div class="text-[24px] md:text-[36px] text-center font-bold">
            <h3>{{__('home.partners') }}</h3>
        </div>
        <div class="mt-[60px]">
            <div class="hidden xl:block">
                <div class="swiper partners-slider">
                    <div class="swiper-wrapper">
                        @foreach($partners as $item)
                            <div class="swiper-slide">
                                <img src="{{ $item->logo }}" alt="{{ $item->logo }}">
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
            <div class="hidden md:block xl:hidden">
                <div class="swiper partners-md-slider">
                    <div class="swiper-wrapper">
                        @foreach($partners as $item)
                            <div class="swiper-slide">
                                <img src="{{ $item->logo }}" alt="{{ $item->logo }}">
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
            <div class="md:hidden">
                <div class="swiper partners-sm-slider">
                    <div class="swiper-wrapper">
                        @foreach($partners as $item)
                            <div class="swiper-slide">
                                <img src="{{ $item->logo }}" alt="{{ $item->logo }}">
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
