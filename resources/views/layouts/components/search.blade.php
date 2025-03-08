<div id="searchModal" class="fixed top-0 left-0 w-full h-full bg-white z-[20] flex items-center justify-center opacity-0 invisible transition-all duration-300">
    <button id="closeSearchModal" class="absolute right-[50px] top-[50px] bg-custom-main w-[50px] h-[50px] flex items-center justify-center text-xl rounded-full text-white">
        <i class="fal fa-times"></i>
    </button>
    <div class="w-full max-w-2xl p-4 -translate-y-10 transition-all duration-300">
        <div class="mx-auto mb-[60px]">
            <object data="/assets/images/logos/logo.svg" type="image/svg+xml" class="bg-custom-main p-[40px] mx-auto rounded-[15px]" style="pointer-events: none;">
                <img src="/assets/images/logos/logo.png" alt="logo">
            </object>
        </div>
        <form action="" class="flex items-center">
            <input type="text" placeholder="Введите запрос..."
                   class="px-[15px] appearance-none outline-none focus:ring-0 w-full border border-custom-main rounded-full mr-[20px]">
            <button type="submit"
                    class="border border-custom-main hover:bg-custom-main text-custom-main hover:text-white px-[50px] py-[10px] rounded-full font-semibold transition-all duration-300">
                Поиск
            </button>
        </form>
    </div>
</div>
