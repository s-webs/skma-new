<div class="flex items-center space-x-4">
    <h2 class="text-4xl font-bold text-center grow-0 text-primary-main uppercase">
        {{ $title }}
    </h2>
    <div class="flex-1 h-0.5 bg-primary-light"></div>
    @isset($link)
        <a href="{{ $link }}" class="text-primary-main hover:underline text-lg font-medium">
            Смотреть все
        </a>
    @endif
</div>
