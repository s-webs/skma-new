<div class="overflow-hidden" x-data="{
    reviews: {{ json_encode($feedbacks) }},
    currentIndex: 0,
    timer: null,
    isPlaying: true,
    init() {
        this.startSlideshow();
    },
    startSlideshow() {
        this.isPlaying = true;
        this.timer = setInterval(() => {
            this.nextSlide();
        }, 5000); // Смена слайда каждые 5 секунд
    },
    stopSlideshow() {
        this.isPlaying = false;
        clearInterval(this.timer);
    },
    toggleSlideshow() {
        if (this.isPlaying) {
            this.stopSlideshow();
        } else {
            this.startSlideshow();
        }
    },
    restartSlideshow() {
        this.stopSlideshow();
        this.startSlideshow();
    },
    nextSlide() {
        this.currentIndex = (this.currentIndex + 1) % this.reviews.length;
        this.restartSlideshow();
    },
    prevSlide() {
        this.currentIndex = (this.currentIndex - 1 + this.reviews.length) % this.reviews.length;
        this.restartSlideshow();
    }
}" class="relative">
    <div class="h-auto xl:h-[840px] bg-custom-main relative">
        <img src="/assets/images/cliparts/spring_01.png" alt="" class="absolute z-[3] w-full h-full object-cover opacity-20">
        <div class="px-1 xs:px-2 xl:container flex items-center justify-center h-full mx-auto pt-[50px] xl:pt-[0px]">
            <div class="flex flex-col xl:flex-row items-center relative z-[5]">
                <div
                    class="w-[280px] xl:w-[500px] 2xl:w-[600px] h-[280px] xl:h-[500px] 2xl:h-[600px] relative border-[5px] xl:border-[20px] border-white/20 rounded-[60px] xl:translate-x-[55px] overflow-hidden">
                    <img :src="reviews[currentIndex].image" :alt="reviews[currentIndex].name"
                         class="w-full h-full object-cover" x-transition:enter="transition ease-in-out duration-500"
                         x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100"
                         x-transition:leave="transition ease-in-out duration-500" x-transition:leave-start="opacity-100"
                         x-transition:leave-end="opacity-0">
                </div>
                <div
                    class="bg-white -translate-y-[50px] xl:-translate-y-[0px] xl:-translate-x-[55px] p-[40px] xl:w-[700px] 2xl:w-[850px] h-auto xl:h-[400px] 2xl:h-[410px] rounded-[30px] relative">
                    <img src="/assets/images/cliparts/wave-03.png" alt=""
                         class="absolute right-[0px] top-[0px] h-full z-[1]">
                    <div class="flex items-center relative z-[5]">
                        <div class="w-[72px] h-[72px] rounded-full overflow-hidden mr-[20px]">
                            <img :src="reviews[currentIndex].image" :alt="reviews[currentIndex].name"
                                 class="w-full h-full object-cover">
                        </div>
                        <div>
                            <div class="text-[18px] text-custom-heading font-bold"
                                 x-text="reviews[currentIndex].name"></div>
                            <div class="text-[14px] text-custom-secondary mt-[8px]"
                                 x-text="reviews[currentIndex].about"></div>
                        </div>
                    </div>
                    <div class="h-[82px] xl:h-[114px] mt-[20px] xl:mt-[40px] relative z-[5] overflow-y-auto pr-[8px]">
                        <p class="text-[14px] md:text-[24px] text-custom-heading"
                           x-text="reviews[currentIndex].message"></p>
                    </div>
                    <div class="mt-[20px] xl:mt-[40px] flex items-center justify-between relative z-[5]">
                        <div class="flex items-center">
                            <template x-for="(review, index) in reviews" :key="index">
                                <div class="h-[8px] mr-[8px] rounded-full"
                                     :class="{'bg-custom-main w-[30px]': currentIndex === index, 'bg-[#DBC5FF] w-[8px]': currentIndex !== index}"></div>
                            </template>
                        </div>
                        <div class="flex items-center">
                            <button @click="toggleSlideshow()"
                                    class="border flex justify-center items-center border-[#E2E2E2] w-[35px] xl:w-[64px] h-[35px] xl:h-[64px] rounded-full text-[10px] xl:text-[14px] text-white hover:text-custom-main mr-[12px] bg-custom-main hover:bg-custom-halftone transition-colors duration-300">
                                <i class="fas"
                                   :class="{'fa-pause': !isPlaying, 'fa-play': isPlaying}"></i>
                            </button>
                            <button @click="prevSlide()"
                                    class="border flex justify-center items-center border-[#E2E2E2] w-[35px] xl:w-[64px] h-[35px] xl:h-[64px] rounded-full text-[16px] xl:text-[30px] text-white hover:text-custom-main mr-[12px] bg-custom-main hover:bg-custom-halftone transition-colors duration-300">
                                <i class="fas fa-angle-left translate-y-[1px]"></i>
                            </button>
                            <button @click="nextSlide()"
                                    class="border flex justify-center items-center border-[#E2E2E2] w-[35px] xl:w-[64px] h-[35px] xl:h-[64px] rounded-full text-[16px] xl:text-[30px] text-white hover:text-custom-main bg-custom-main hover:bg-custom-halftone transition-colors duration-300">
                                <i class="fas fa-angle-right translate-y-[1px]"></i>
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
