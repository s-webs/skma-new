{{-- TopHeader --}}
<div class="bg-custom-dark py-[13px] font-semibold">
    <div class="container px-4 2xl:px-[16px] mx-auto justify-between flex items-center">
        <div class="flex items-center text-[18px] text-white lg:mr-[44px]">
            <a href="https://www.facebook.com/ukma.kz/?locale=ru_RU" target="_blank" class="mr-[16px]"><i class="fab fa-facebook"></i></a>
            <a href="https://www.instagram.com/medacadem_skma/" target="_blank" class="mr-[16px]"><i class="fab fa-instagram"></i></a>
            <a href="https://www.youtube.com/@skma-edu-kz" target="_blank" class="mr-[16px]"><i class="fab fa-youtube"></i></a>
			<a href="https://www.tiktok.com/@oqma_skma?_r=1&_t=ZM-91wGY6eRN1A" target="_blank" class="mr-[16px]"><i class="fab fa-tiktok"></i></a>		
			
			<a href="https://t.me/skma_info" target="_blank"><i class="fab fa-telegram"></i></a>
        </div>
        <div class="text-white text-[16px] hidden lg:block">
            <a href="tel:8725239-57-57" class="mr-[22px]">
                <i class="fas fa-phone-alt mr-[7.69px]"></i>8 7252 39-57-57
            </a>
            <a href="mailto:info@skma.kz">
                <i class="fas fa-envelope-open mr-[7.69px]"></i>info@skma.kz
            </a>
        </div>
        <div class="flex-1"></div>
        <div>
            <button id="enable-pc-impaired" class="text-white flex items-center">
                <i class="fas fa-eye mr-[6.75px]"></i>
                <span class="hidden md:block">{{ __('public.version_for_the_visually_impaired') }}</span>
            </button>
        </div>
        <div class="text-white ml-[16px] md:ml-[44px]">
            <a href="/kz{{$kzLink ? '/' . $kzLink : ''}}{{$page ?? ''}}">ҚАЗ</a>
            <a href="/ru{{$ruLink ? '/' . $ruLink : ''}}{{$page ?? ''}}" class="mx-[16px]">РУС</a>
            <a href="/en{{$enLink ? '/' . $enLink : ''}}{{$page ?? ''}}">ENG</a>
        </div>
    </div>
</div>
{{-- /TopHeader --}}
