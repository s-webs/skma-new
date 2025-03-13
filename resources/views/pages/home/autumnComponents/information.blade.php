<div class="relative bg-autumn-main 2xl:h-[355px] overflow-hidden">
    <img src="/assets/images/cliparts/autumn_01.png" alt="" class="absolute w-full h-full object-cover z-[3] opacity-20">
    <div class="container mx-auto px-2 2xl:px-[300px] relative z-[5]">
        <div class="flex items-center justify-between">
            <div class="py-[16px] md:py-[0px]">
                <div class="text-[14px] md:text-[24px] 2xl:text-[36px] text-white font-bold">
                    <h3>
                        {{ __('applicant.information_for_applicants') }}
                    </h3>
                </div>
                <div class="text-white text-[10px] md:text-[16px] mt-[10px] md:mt-[24px]">
                    <p>
                        {{ __('applicant.information_about_admission_documents') }}
                    </p>
                </div>
                <div class="mt-[16px] md:mt-[32px] 2xl:mt-[64px]">
                    <a href="{{ route('applicant.index') }}"
                       class="px-[16px] md:px-[31px] py-[8px] md:py-[21px] bg-white hover:bg-autumn-main text-[12px] md:text-[18px] font-semibold text-autumn-main hover:text-white transition-all duration-300 rounded-full">{{ __('home.detail') }}</a>
                </div>
            </div>
            <div class="w-[248px] translate-y-[27px]">
                <img src="/assets/images/cliparts/student_01.png" alt="">
            </div>
        </div>
    </div>
</div>
