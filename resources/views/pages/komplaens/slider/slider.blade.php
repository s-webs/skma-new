<div class="hidden xl:block">
    <div class="swiper gallery-slider mt-[60px]">
        <div class="swiper-wrapper">
            @foreach($gallery as $image)
                <div class="swiper-slide">
                    <img src="/{{ $image }}" alt="{{ $image }}" class="w-auto h-[300px] object-cover rounded-[20px]">
                </div>
            @endforeach
        </div>
    </div>
</div>
<div class="hidden md:block xl:hidden">
    <div class="swiper gallery-md-slider mt-[60px]">
        <div class="swiper-wrapper">
            @foreach($gallery as $image)
                <div class="swiper-slide">
                    <img src="/{{ $image }}" alt="{{ $image }}" class="h-[200px] object-cover rounded-[20px]">
                </div>
            @endforeach
        </div>
    </div>
</div>
<div class="md:hidden">
    <div class="swiper gallery-sm-slider mt-[30px]">
        <div class="swiper-wrapper">
            @foreach($gallery as $image)
                <div class="swiper-slide">
                    <img src="/{{ $image }}" alt="{{ $image }}" class="h-[150px] object-cover rounded-[20px]">
                </div>
            @endforeach
        </div>
    </div>
</div>
