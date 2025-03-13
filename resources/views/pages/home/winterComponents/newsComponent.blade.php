<div class="bg-white">
    <div class="px-2 xl:container mx-auto">
        <div class="py-[44px] xl:py-[100px] flex flex-col xl:flex-row justify-center items-center">
            <div class="w-full xl:px-0 xl:w-[842px] xl:mr-[100px]">
                <div class="overflow-hidden h-[300px] sm:h-[400px] xl:h-[512px] rounded-[20px]">
                    <img src="{{ $latestArticle->preview_ru }}" alt="{{ $latestArticle->getProperty('title') }}"
                         class="w-full h-full object-cover">
                </div>
                <div class="flex items-center mt-[24px] md:mt-[37px] text-[14px] sm:text-[16px] text-winter-heading">
                    <div class="flex items-center mr-[20px]">
                        <i class="fad fa-calendar-alt text-winter-secondary"></i><span
                            class="ml-[6px]">{{ $latestArticle->formatted_date }}</span>
                    </div>
                    <div class="flex items-center mr-[20px]">
                        <i class="fas fa-eye text-winter-secondary"></i><span
                            class="ml-[6px]">{{ $latestArticle->getProperty('views') }}</span>
                    </div>
                    <div class="flex items-center mr-[20px]">
                        <i class="fas fa-heart text-winter-secondary"></i><span
                            class="ml-[6px]">{{ $latestArticle->likes->count() }}</span>
                    </div>
                    <div class="flex items-center">
                        <i class="fas fa-comment text-winter-secondary"></i><span
                            class="ml-[6px]">{{ $latestArticle->comments->count() }}</span>
                    </div>
                </div>
                <div
                    class="text-[18px] md:text-[32px] mt-[24px] font-bold text-winter-heading">{{ $latestArticle->getProperty('title') }}</div>
                <div class="mt-[24px] flex">
                    <a href="{{ route('news.show', $latestArticle->getProperty('slug')) }}"
                       class="relative flex justify-between items-center bg-winter-main rounded-full overflow-hidden group transition-all duration-300 hover:shadow-lg hover:scale-105">
                        <div
                            class="text-[14px] lg:text-[18px] pl-[31px] font-semibold text-white relative z-10 transition-all duration-300">
                            {{ __('home.readArticle') }}
                        </div>
                        <div
                            class="flex items-center justify-center ml-[21px] w-[40px] md:w-[64px] h-[40px] md:h-[64px] bg-winter-extra text-white rounded-full relative z-10 transition-all duration-300 group-hover:bg-winter-extra group-hover:scale-110">
                            <i class="fal fa-arrow-right text-[20px]"></i>
                        </div>
                    </a>

                    <div class="flex-1"></div>
                </div>
            </div>
            <div class="w-full xl:w-auto mt-[44px] xl:mt-[0]">
                <div class="flex items-center justify-between mb-[24px]">
                    <h3 class="uppercase text-[14px] xl:text-[24px] font-bold">{{ __('home.academyNews') }}</h3>
                    <a href="{{ route('news.index') }}"
                       class="font-semibold text-[14px] xl:text-[18px] text-winter-main flex items-center group">
                        <span class="mr-[5px] xl:mr-[10px]">{{ __('home.allNews') }}</span>
                        <i class="fal fa-angle-right text-[14px] xl:text-[24px] translate-y-[2px] group-hover:translate-x-[5px] transition-transform duration-300"></i>
                    </a>
                </div>
                @foreach($news as $item)
                    <div class="flex items-center py-[24px] border-[#E2E2E2] border-t group">
                        <a href="{{ route('news.show', $item->getProperty('slug')) }}"
                           class="w-[75px] xs:w-[96px] h-[75px] xs:h-[96px] rounded-[10px] mr-[10px] md:mr-[20px] group overflow-hidden flex-shrink-0">
                            <img src="{{ $item->preview_ru }}" alt="{{ $item->getProperty('title') }}"
                                 class="w-full h-full object-cover transition-transform duration-300 group-hover:scale-110">
                        </a>
                        <div class="text-[12px] xs:text-[16px] font-semibold">
                            <div class="h-[53px] xs:h-auto">
                                <a href="{{ route('news.show', $item->getProperty('slug')) }}" class="transition-colors duration-300 group-hover:text-winter-main">
                                    {{ $item->getProperty('title') }}
                                </a>
                            </div>
                            <div class="flex items-center mt-[5px] xs:mt-[24px] text-[10px] xs:text-[14px] text-winter-secondary">
                                <div class="flex items-center mr-[16px]">
                                    <i class="fad fa-calendar-alt xs:translate-y-[2px]"></i>
                                    <span class="ml-[6px]">{{ $item->formatted_date }}</span>
                                </div>
                                <div class="flex items-center mr-[16px]">
                                    <i class="fas fa-eye xs:translate-y-[2px]"></i>
                                    <span class="ml-[6px]">{{ $item->getProperty('views') }}</span>
                                </div>
                                <div class="flex items-center mr-[16px]">
                                    <i class="fas fa-heart xs:translate-y-[2px]"></i>
                                    <span class="ml-[6px]">{{ $item->likes->count() }}</span>
                                </div>
                                <div class="flex items-center">
                                    <i class="fas fa-comment xs:translate-y-[2px]"></i>
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
