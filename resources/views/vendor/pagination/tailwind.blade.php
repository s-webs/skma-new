@if ($paginator->hasPages())
    <nav role="navigation" aria-label="{{ __('Pagination Navigation') }}" class="flex items-center justify-between">
        <div class="flex justify-between flex-1 sm:hidden">
            @if ($paginator->onFirstPage())
                <span class="text-xl bg-[var(--color-secondary)] px-[25px] py-[7px] text-white rounded-[10px]">
                    <i class="fal fa-angle-left"></i>
                </span>
            @else
                <a href="{{ $paginator->previousPageUrl() }}"
                   class="text-xl bg-[var(--color-main)] px-[25px] py-[7px] text-white rounded-[10px]">
                    <i class="fal fa-angle-right"></i>
                </a>
            @endif

            @if ($paginator->hasMorePages())
                <a href="{{ $paginator->nextPageUrl() }}"
                   class="text-xl bg-[var(--color-main)] px-[25px] py-[7px] text-white rounded-[10px]">
                    <i class="fal fa-angle-right"></i>
                </a>
            @else
                <span class="text-xl bg-[var(--color-secondary)] px-[25px] py-[7px] text-white rounded-[10px]">
                    <i class="fal fa-angle-right"></i>
                </span>
            @endif
        </div>

        <div class="hidden sm:flex-1 sm:flex sm:items-center sm:justify-center">
            <div>
                <span class="relative z-0 inline-flex rtl:flex-row-reverse">
                    {{-- Previous Page Link --}}
                    @if ($paginator->onFirstPage())
                        <span aria-disabled="true" aria-label="{{ __('pagination.previous') }}">
                            <span
                                class="w-[44px] h-[44px] flex items-center justify-center text-[24px] text-[var(--color-secondary)]"
                                aria-hidden="true">
                                <i class="fal fa-angle-left"></i>
                            </span>
                        </span>
                    @else
                        <a href="{{ $paginator->previousPageUrl() }}" rel="prev"
                           class="text-[var(--color-secondary)] hover:text-[var(--color-main)]"
                           aria-label="{{ __('pagination.previous') }}">
                            <span class="w-[44px] h-[44px] flex items-center justify-center text-[24px]"
                                  aria-hidden="true">
                                <i class="fal fa-angle-left"></i>
                            </span>
                        </a>
                    @endif

                    {{-- Pagination Elements --}}
                    @foreach ($elements as $element)
                        {{-- "Three Dots" Separator --}}
                        @if (is_string($element))
                            <span aria-disabled="true" class="w-[44px] h-[44px] flex items-center justify-center">
                                <span class="text-[var(--color-secondary)] -translate-y-[3px]">{{ $element }}</span>
                            </span>
                        @endif

                        {{-- Array Of Links --}}
                        @if (is_array($element))
                            @foreach ($element as $page => $url)
                                @if ($page == $paginator->currentPage())
                                    <span aria-current="page"
                                          class="w-[44px] h-[44px] mx-[7.5px] flex items-center justify-center text-white rounded-full bg-[var(--color-main)]">
                                        <span class="">{{ $page }}</span>
                                    </span>
                                @else
                                    {{-- Условия для отображения номеров страниц --}}
                                    @if ($page <= 4 || $page > $paginator->lastPage() - 3 || abs($page - $paginator->currentPage()) <= 1)
                                        <a href="{{ $url }}"
                                           class="w-[44px] h-[44px] mx-[7.5px] flex items-center justify-center"
                                           aria-label="{{ __('Go to page :page', ['page' => $page]) }}">
                                            {{ $page }}
                                        </a>
                                    @elseif (abs($page - $paginator->currentPage()) == 2)
                                        <span aria-disabled="true"
                                              class="w-[44px] h-[44px] flex items-center justify-center">
                                            <span class="text-[var(--color-secondary)] -translate-y-[3px]">...</span>
                                        </span>
                                    @endif
                                @endif
                            @endforeach
                        @endif
                    @endforeach

                    {{-- Next Page Link --}}
                    @if ($paginator->hasMorePages())
                        <a href="{{ $paginator->nextPageUrl() }}" rel="next"
                           class="text-[var(--color-secondary)] hover:text-[var(--color-main)]"
                           aria-label="{{ __('pagination.next') }}">
                            <span class="w-[44px] h-[44px] flex items-center justify-center text-[24px]"
                                  aria-hidden="true">
                                <i class="fal fa-angle-right"></i>
                            </span>
                        </a>
                    @else
                        <span aria-disabled="true" aria-label="{{ __('pagination.next') }}">
                            <span
                                class="w-[44px] h-[44px] flex items-center justify-center text-[24px] text-[var(--color-secondary)]"
                                aria-hidden="true">
                                <i class="fal fa-angle-right"></i>
                            </span>
                        </span>
                    @endif
                </span>
            </div>
        </div>
    </nav>
@endif
