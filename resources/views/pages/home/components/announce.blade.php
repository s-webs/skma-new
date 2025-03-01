<div class="bg-[#F9F5FF] overflow-hidden hidden xl:block" x-data="{ slideIndex: 0, slides: {{ json_encode($announcements) }} }">
    <div class="flex items-center justify-between py-[120px] uxl:container uxl:mx-auto">
        <div class="flex-1 flex mr-[80px] pl-[16px]">
            <div class="flex-1"></div>
            <div class="w-[767px]">
                <div x-transition:enter="transition ease-in-out duration-300"
                     x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100"
                     x-transition:leave="transition ease-in-out duration-300"
                     x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0">
                    <div>
                        <span class="py-[11px] px-[21px] bg-custom-primary text-custom-main font-bold rounded-[10px]">Объявление</span>
                    </div>
                    <div class="text-[44px] font-bold mt-[24px] text-custom-heading">
                        <h2 x-text="slides[slideIndex].title"></h2>
                    </div>
                    <div class="mt-[24px] text-[18px] text-custom-secondary leading-[35px]">
                        <p x-text="slides[slideIndex].description"></p>
                    </div>

                    <div class="mt-[64px] flex items-center">
                        <div class="mr-[44px]">
                            <a :href="slides[slideIndex].link" class="px-[31px] py-[21px] bg-custom-main rounded-full text-white font-semibold">Подробнее</a>
                        </div>
                        <div class="flex items-center">
                            <button @click="slideIndex = (slideIndex - 1 + slides.length) % slides.length"
                                    class="border flex justify-center items-center border-[#E2E2E2] w-[64px] h-[64px] rounded-full text-[30px] text-custom-main hover:text-custom-halftone mr-[12px] hover:bg-custom-main transition-colors duration-300">
                                <i class="fas fa-angle-left"></i>
                            </button>
                            <button @click="slideIndex = (slideIndex + 1) % slides.length"
                                    class="border flex justify-center items-center border-[#E2E2E2] w-[64px] h-[64px] rounded-full text-[30px] text-custom-main hover:text-custom-halftone mr-[12px] hover:bg-custom-main transition-colors duration-300">
                                <i class="fas fa-angle-right"></i>
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="relative border-[20px] w-[728px] h-[623px] border-custom-primary rounded-tl-[60px] rounded-bl-[60px] uxl:rounded-tr-[60px] uxl:rounded-br-[60px] translate-x-[20px] uxl:translate-x-0 overflow-hidden">
            <img :src="slides[slideIndex].image" :alt="slides[slideIndex].title" class="w-full h-full object-cover" x-cloak>
            <div class="absolute bottom-[20px] left-[30px] flex">
                <template x-for="(slide, index) in slides" :key="index">
                    <div class="h-[8px] bg-white mr-[8px] rounded-full"
                         :class="{ 'w-[30px] opacity-100': slideIndex === index, 'opacity-40 w-[8px]': slideIndex !== index }"></div>
                </template>
            </div>
        </div>
    </div>
</div>
