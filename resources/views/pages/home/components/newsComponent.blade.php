<div class="bg-white">
    <div class="container px-2 xl:px-0 mx-auto">
        <div class="py-[100px] flex flex-col xl:flex-row justify-center items-center">
            <div class="w-full px-4 xl:px-0 xl:w-[842px] xl:mr-[100px]">
                <div class="overflow-hidden h-[512px] rounded-[20px]">
                    <img src="{{ $latestArticle->preview_ru }}" alt="{{ $latestArticle->getProperty('title') }}"
                         class="w-full h-full object-cover">
                </div>
                <div class="flex items-center mt-[37px] text-custom-heading">
                    <div class="flex items-center mr-[20px]">
                        <i class="fad fa-calendar-alt text-custom-secondary"></i><span class="ml-[6px]">{{ $latestArticle->formatted_date }}</span>
                    </div>
                    <div class="flex items-center mr-[20px]">
                        <i class="fas fa-eye text-custom-secondary"></i><span class="ml-[6px]">{{ $latestArticle->getProperty('views') }}</span>
                    </div>
                    <div class="flex items-center mr-[20px]">
                        <i class="fas fa-heart text-custom-secondary"></i><span class="ml-[6px]">{{ $latestArticle->likes->count() }}</span>
                    </div>
                    <div class="flex items-center">
                        <i class="fas fa-comment text-custom-secondary"></i><span class="ml-[6px]">{{ $latestArticle->comments->count() }}</span>
                    </div>
                </div>
                <div class="text-[32px] mt-[24px] font-bold text-custom-heading">{{ $latestArticle->getProperty('title') }}</div>
                <div class="mt-[24px] flex">
                    <a href="{{ route('news.show', $latestArticle->getProperty('slug')) }}" class="relative flex justify-between items-center bg-custom-main rounded-full overflow-hidden group transition-all duration-300 hover:shadow-lg hover:scale-105">
                        <div class="text-[18px] pl-[31px] font-semibold text-white relative z-10 transition-all duration-300">
                            {{ __('home.readArticle') }}
                        </div>
                        <div class="flex items-center justify-center ml-[21px] w-[64px] h-[64px] bg-[#914EFF] text-white rounded-full relative z-10 transition-all duration-300 group-hover:bg-[#6835B8] group-hover:scale-110">
                            <i class="fal fa-arrow-right text-[20px]"></i>
                        </div>
                    </a>

                    <div class="flex-1"></div>
                </div>
            </div>
            <div class="mt-[44px] xl:mt-[0]">
                <div class="flex items-center justify-between mb-[24px]">
                    <h3 class="uppercase text-[24px] font-bold">{{ __('home.academyNews') }}</h3>
                    <a href="{{ route('news.index') }}"
                       class="font-semibold text-[18px] text-custom-main flex items-center"><span
                            class="mr-[10px]">{{ __('home.allNews') }}</span><i
                            class="fal fa-angle-right text-[24px]"></i></a>
                </div>
                @foreach($news as $item)
                    <div class="flex items-center py-[24px] border-[#E2E2E2] border-t px-2 xl:px-0">
                        <a href="{{ route('news.show', $item->getProperty('slug')) }}" class="w-[96px] h-[96px] rounded-[10px] mr-[20px] overflow-hidden">
                            <img src="{{ $item->preview_ru }}" alt="{{ $item->getProperty('title') }}"
                                 class="w-full h-full object-cover">
                        </a>
                        <div class="text-[16px] font-semibold">
                            <div class="">
                                <a href="{{ route('news.show', $item->getProperty('slug')) }}" class="">
                                    {{ $item->getProperty('title') }}
                                </a>
                            </div>
                            <div class="flex items-center mt-[24px] text-[14px] text-custom-secondary">
                                <div class="flex items-center mr-[16px]">
                                    <i class="fad fa-calendar-alt translate-y-[2px]"></i>
                                    <span class="ml-[6px]">{{ $item->formatted_date }}</span>
                                </div>
                                <div class="flex items-center mr-[16px]">
                                    <i class="fas fa-eye translate-y-[2px]"></i>
                                    <span class="ml-[6px]">{{ $item->getProperty('views') }}</span>
                                </div>
                                <div class="flex items-center mr-[16px]">
                                    <i class="fas fa-heart translate-y-[2px]"></i>
                                    <span class="ml-[6px]">{{ $item->likes->count() }}</span>
                                </div>
                                <div class="flex items-center">
                                    <i class="fas fa-comment translate-y-[2px]"></i>
                                    <span class="ml-[6px]">{{ $item->comments->count() }}</span>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
</div>
