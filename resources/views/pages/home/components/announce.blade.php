<div class="bg-[var(--color-halftone)] overflow-hidden hidden xl:block" x-data="{ slideIndex: 0, slides: {{ json_encode($announcements) }} }">
    <div class="flex items-center justify-between py-[120px] uxl:container uxl:mx-auto">
        <div class="flex-1 flex mr-[80px] pl-[16px]">
            <div class="flex-1"></div>
            <div class="w-[767px]">
                <div x-transition:enter="transition ease-in-out duration-300"
                     x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100"
                     x-transition:leave="transition ease-in-out duration-300"
                     x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0">
                    <div>
                        <span class="py-[11px] px-[21px] bg-[var(--color-primary)] text-[var(--color-main)] font-bold rounded-[10px]">{{ __('home.announce') }}</span>
                    </div>
                    <div class="text-[44px] font-bold mt-[24px] text-[var(--color-heading)]">
                        <h2 x-text="slides[slideIndex].title"></h2>
                    </div>
                    <div class="mt-[24px] text-[18px] text-custom-secondary leading-[35px]">
                        <p x-text="slides[slideIndex].description"></p>
                    </div>

                    <div class="mt-[64px] flex items-center">
                        <div class="mr-[44px]" x-show="slides[slideIndex].link">
                            <a :href="slides[slideIndex].link" class="relative flex justify-between items-center bg-[var(--color-main)] rounded-full overflow-hidden group transition-all duration-300 hover:shadow-lg hover:scale-105">
                                <!-- Текст -->
                                <div class="text-[18px] pl-[31px] font-semibold text-white relative z-10 transition-all duration-300">
                                    {{ __('home.detail') }}
                                </div>
                                <!-- Иконка -->
                                <div class="flex items-center justify-center ml-[21px] w-[64px] h-[64px] bg-[var(--color-extra)] text-white rounded-full relative z-10 transition-all duration-300 group-hover:bg-[var(--color-extra)] group-hover:scale-110">
                                    <i class="fal fa-arrow-right text-[20px]"></i>
                                </div>
                            </a>
                        </div>
                        <div class="flex items-center">
                            <button @click="slideIndex = (slideIndex - 1 + slides.length) % slides.length"
                                    class="border flex justify-center items-center border-[#E2E2E2] w-[64px] h-[64px] rounded-full text-[30px] text-[var(--color-main)] hover:text-[var(--color-halftone)] mr-[12px] hover:bg-[var(--color-main)] transition-colors duration-300">
                                <i class="fas fa-angle-left"></i>
                            </button>
                            <button @click="slideIndex = (slideIndex + 1) % slides.length"
                                    class="border flex justify-center items-center border-[#E2E2E2] w-[64px] h-[64px] rounded-full text-[30px] text-[var(--color-main)] hover:text-[var(--color-halftone)] mr-[12px] hover:bg-[var(--color-main)] transition-colors duration-300">
                                <i class="fas fa-angle-right"></i>
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="relative border-[20px] w-[728px] h-[623px] border-[var(--color-primary)] rounded-tl-[60px] rounded-bl-[60px] uxl:rounded-tr-[60px] uxl:rounded-br-[60px] translate-x-[20px] uxl:translate-x-0 overflow-hidden">
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
