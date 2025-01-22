<div class="flex justify-center lg:justify-between items-center lg:space-x-4">
    <h2 class="text-4xl font-bold text-center lg:text-start grow-0 text-primary-main uppercase">
        {{ $title }}
    </h2>
    <div class="hidden lg:block lg:flex-1 h-0.5 bg-primary-light"></div>
    @isset($link)
        <a href="{{ $link }}" class="text-primary-main hover:underline text-lg font-medium">
            Смотреть все
        </a>
    @endif
</div>
