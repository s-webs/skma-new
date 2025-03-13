<div class="bg-[#F9F5FF] xl:hidden pt-[44px] pb-[44px] md:pb-[64px] md:pt-[64px] px-2"
     x-data="{ slideIndex: 0, slides: {{ json_encode($announcements) }} }">
    <div
        class="relative border-[5px] w-full h-[300px] md:h-[450px] border-inside border-winter-primary rounded-[20px] overflow-hidden">
        <img :src="slides[slideIndex].image" :alt="slides[slideIndex].title" class="w-full h-full object-cover" x-cloak>
        <div class="absolute bottom-[20px] left-[30px] flex">
            <template x-for="(slide, index) in slides" :key="index">
                <div class="h-[8px] bg-white mr-[8px] rounded-full"
                     :class="{ 'w-[30px] opacity-100': slideIndex === index, 'opacity-40 w-[8px]': slideIndex !== index }"></div>
            </template>
        </div>
    </div>
    <div class="flex items-center justify-between">
        <div class="w-full">
            <div x-transition:enter="transition ease-in-out duration-300"
                 x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100"
                 x-transition:leave="transition ease-in-out duration-300"
                 x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0">
                <div class="flex items-center justify-between mt-[16px]">
                    <div class="text-[14px]">
                        <span class="py-[7px] px-[10px] bg-winter-primary text-winter-main font-bold rounded-[10px]">{{ __('home.announce') }}</span>
                    </div>
                    <div class="flex items-center">
                        <button @click="slideIndex = (slideIndex - 1 + slides.length) % slides.length"
                                class="border flex justify-center items-center border-[#E2E2E2] w-[35px] h-[35px] rounded-full text-[16px] text-winter-main hover:text-winter-halftone mr-[12px] hover:bg-winter-main transition-colors duration-300">
                            <i class="fas fa-angle-left"></i>
                        </button>
                        <button @click="slideIndex = (slideIndex + 1) % slides.length"
                                class="border flex justify-center items-center border-[#E2E2E2] w-[35px] h-[35px] rounded-full text-[16px] text-winter-main hover:text-winter-halftone mr-[12px] hover:bg-winter-main transition-colors duration-300">
                            <i class="fas fa-angle-right"></i>
                        </button>
                    </div>
                </div>
                <div class="text-[20px] font-bold mt-[24px] text-winter-heading">
                    <h2 x-text="slides[slideIndex].title"></h2>
                </div>
                <div class="mt-[16px] text-[16px] text-winter-secondary leading-[23px]">
                    <p x-text="slides[slideIndex].description"></p>
                </div>

                <div class="mt-[24px]" x-show="slides[slideIndex].link">
                    <div class="">
                        <a :href="slides[slideIndex].link"
                           class="px-[15px] py-[10px] bg-winter-main rounded-full text-white font-semibold">{{ __('home.detail') }}</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
