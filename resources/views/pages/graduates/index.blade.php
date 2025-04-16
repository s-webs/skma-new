@extends('layouts.public', ['kzLink' => 'graduates', 'ruLink' => 'graduates', 'enLink' => 'graduates'])

@section('content')
    <div class="container mx-auto px-4" x-data="graduatesSearch()" x-init="init()">
        <div class="mt-[40px]">
            <x-breadcrumbs :items="[
            ['title' => __('public.pageHome'), 'url' => route('home')],
            ['title' => __('graduates.for_graduates')]
        ]"/>
        </div>

        <div class="mt-[40px] mb-[60px] pb-[50px] xl:pb-[100px] bg-white pt-[30px] px-[40px] rounded-[15px] shadow-md">
            <div>
                <x-page-title>{{ __('graduates.for_graduates') }}</x-page-title>
            </div>

            <!-- Форма фильтрации -->
            <div class="mt-[60px]">
                <div class="flex flex-wrap justify-center md:justify-start items-center xl:space-x-4">
                    <!-- Выбор года "с" -->
                    <div class="mr-2 md:mr-0">
                        <span class="mr-[6px] text-gray-500">{{ __('graduates.from') }}</span>
                        <select x-model="yearFrom" class="rounded-[10px] border-gray-300 text-gray-500" @change="search(1)">
                            @foreach($years as $year)
                                <option value="{{ $year }}">{{ $year }}</option>
                            @endforeach
                        </select>
                    </div>
                    <!-- Выбор года "по" -->
                    <div>
                        <span class="mr-[6px] text-gray-500">{{ __('graduates.to') }}</span>
                        <select x-model="yearTo" class="rounded-[10px] border-gray-300 text-gray-500" @change="search(1)">
                            @foreach($years as $year)
                                <option value="{{ $year }}">{{ $year }}</option>
                            @endforeach
                        </select>
                    </div>
                    <!-- Выбор факультета -->
                    <div class="w-full xl:w-auto my-4 xl:my-0">
                        <select x-model="faculty" class="w-full rounded-[10px] border-gray-300 text-gray-500" @change="search(1)">
                            <option value="">{{ __('graduates.select_faculty') }}</option>
                            @foreach($faculties as $faculty)
                                <option value="{{ $faculty }}">{{ $faculty }}</option>
                            @endforeach
                        </select>
                    </div>
                    <!-- Поле ввода имени -->
                    <div class="w-full xl:w-auto">
                        <input type="text" placeholder="{{ __('graduates.enter_name') }}" x-model="name"
                               class="w-full rounded-[10px] border-gray-300" @input.debounce.500ms="search(1)">
                    </div>
                </div>
            </div>

            <!-- Вывод результатов -->
            <div class="flex flex-wrap justify-center mt-[30px]">
                <!-- Индикатор загрузки -->
                <template x-if="loading">
                    <div class="w-full text-center text-gray-500">{{ __('graduates.loading') }}...</div>
                </template>

                <!-- Динамический вывод выпускников -->
                <template x-for="graduate in graduates" :key="graduate.id">
                    <div class="border border-[var(--color-main)] rounded-[10px] p-[10px] md:p-[24px] my-[12px] xl:mx-[12px] w-full xl:w-[30%]">
                        <div class="flex items-center justify-between">
                            <div class="mr-[24px]">
                                @if(app()->getLocale() === 'en')
                                    <div class="md:text-lg font-semibold" x-text="graduate.name_latin">
                                        Фамилия Имя Отчество
                                    </div>
                                @else
                                    <div class="md:text-lg font-semibold" x-text="graduate.name">
                                        Фамилия Имя Отчество
                                    </div>
                                @endif
                                <div class="text-sm mt-[10px] text-gray-500">
                                    <span class="font-semibold mr-2">{{ __('graduates.faculty') }}:</span>
                                    <span x-text="graduate['faculty_' + locale]">Факультет</span>
                                </div>
                                <div class="text-sm text-gray-500">
                                    <span class="font-semibold mr-2">{{ __('graduates.graduation_year') }}:</span>
                                    <span x-text="graduate.year">1984</span>
                                </div>
                            </div>
                            <div class="border w-[64px] h-[64px] md:w-[100px] md:h-[100px] rounded-full overflow-hidden shrink-0">
                                <img :src="graduate.photo ? graduate.photo : '/assets/images/no_photo.png'" alt=""
                                     class="w-full h-full object-cover rounded-full">
                            </div>
                        </div>
                    </div>
                </template>
            </div>

            <!-- Элементы пагинации -->
            <div class="mt-4">
                <!-- Мобильная версия (sm:hidden) -->
                <div class="flex justify-between flex-1 sm:hidden">
                    <template x-if="currentPage === 1">
                    <span class="text-xl bg-[var(--color-secondary)] px-[25px] py-[7px] text-white rounded-[10px]">
                        <i class="fal fa-angle-left"></i>
                    </span>
                    </template>
                    <template x-if="currentPage > 1">
                        <button @click="goToPage(currentPage - 1)"
                                class="text-xl bg-[var(--color-main)] px-[25px] py-[7px] text-white rounded-[10px]">
                            <i class="fal fa-angle-left"></i>
                        </button>
                    </template>
                    <template x-if="currentPage < lastPage">
                        <button @click="goToPage(currentPage + 1)"
                                class="text-xl bg-[var(--color-main)] px-[25px] py-[7px] text-white rounded-[10px]">
                            <i class="fal fa-angle-right"></i>
                        </button>
                    </template>
                    <template x-if="currentPage === lastPage">
                    <span class="text-xl bg-[var(--color-secondary)] px-[25px] py-[7px] text-white rounded-[10px]">
                        <i class="fal fa-angle-right"></i>
                    </span>
                    </template>
                </div>

                <!-- Версия для экранов sm и больше -->
                <div class="hidden sm:flex-1 sm:flex sm:items-center sm:justify-center">
                    <div>
                    <span class="relative z-0 inline-flex rtl:flex-row-reverse">
                        <!-- Предыдущая страница -->
                        <template x-if="currentPage === 1">
                            <span aria-disabled="true" aria-label="Previous">
                                <span class="w-[44px] h-[44px] flex items-center justify-center text-[24px] text-[var(--color-secondary)]">
                                    <i class="fal fa-angle-left"></i>
                                </span>
                            </span>
                        </template>
                        <template x-if="currentPage > 1">
                            <button @click="goToPage(currentPage - 1)" rel="prev"
                                    class="text-[var(--color-secondary)] hover:text-[var(--color-main)]"
                                    aria-label="Previous">
                                <span class="w-[44px] h-[44px] flex items-center justify-center text-[24px]">
                                    <i class="fal fa-angle-left"></i>
                                </span>
                            </button>
                        </template>

                        <!-- Номера страниц -->
                        <template x-for="item in generatePages()" :key="item.key">
                            <template x-if="item.type == 'page'">
                                <template x-if="item.current">
                                    <span aria-current="page"
                                          class="w-[44px] h-[44px] mx-[7.5px] flex items-center justify-center text-white rounded-full bg-[var(--color-main)]">
                                        <span x-text="item.page"></span>
                                    </span>
                                </template>
                                <template x-if="!item.current">
                                    <button @click="goToPage(item.page)"
                                            class="w-[44px] h-[44px] mx-[7.5px] flex items-center justify-center"
                                            :aria-label="'Go to page ' + item.page">
                                        <span x-text="item.page"></span>
                                    </button>
                                </template>
                            </template>
                            <template x-if="item.type == 'dots'">
                                <span aria-disabled="true" class="w-[44px] h-[44px] flex items-center justify-center">
                                    <span class="text-[var(--color-secondary)] -translate-y-[3px]" x-text="item.text"></span>
                                </span>
                            </template>
                        </template>

                        <!-- Следующая страница -->
                        <template x-if="currentPage < lastPage">
                            <button @click="goToPage(currentPage + 1)" rel="next"
                                    class="text-[var(--color-secondary)] hover:text-[var(--color-main)]"
                                    aria-label="Next">
                                <span class="w-[44px] h-[44px] flex items-center justify-center text-[24px]">
                                    <i class="fal fa-angle-right"></i>
                                </span>
                            </button>
                        </template>
                        <template x-if="currentPage >= lastPage">
                            <span aria-disabled="true" aria-label="Next">
                                <span class="w-[44px] h-[44px] flex items-center justify-center text-[24px] text-[var(--color-secondary)]">
                                    <i class="fal fa-angle-right"></i>
                                </span>
                            </span>
                        </template>
                    </span>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Подключение Alpine.js -->
    <script src="//unpkg.com/alpinejs" defer></script>
    <script>
        function graduatesSearch() {
            return {
                locale: '{{ app()->getLocale() }}',
                yearFrom: '{{ $years->first() }}',
                yearTo: '{{ $years->last() }}',
                faculty: '',
                name: '',
                graduates: [],
                loading: false,
                currentPage: 1,
                lastPage: 1,

                init() {
                    this.search(1);
                },
                search(page = 1) {
                    this.loading = true;
                    let params = new URLSearchParams({
                        yearFrom: this.yearFrom,
                        yearTo: this.yearTo,
                        faculty: this.faculty,
                        name: this.name,
                        locale: this.locale,
                        page: page
                    });
                    fetch(`/graduates/search?${params.toString()}`)
                        .then(response => response.json())
                        .then(data => {
                            this.graduates = data.data;
                            this.currentPage = data.current_page;
                            this.lastPage = data.last_page;
                        })
                        .catch(error => console.error('Ошибка запроса:', error))
                        .finally(() => this.loading = false);
                },
                goToPage(page) {
                    if (page >= 1 && page <= this.lastPage) {
                        this.search(page);
                    }
                },
                generatePages() {
                    let pages = [];
                    let current = this.currentPage;
                    let last = this.lastPage;

                    for (let i = 1; i <= last; i++) {
                        // Отображаем первые 4 страницы, последние 3 и страницы вокруг текущей
                        if (i <= 4 || i > last - 3 || Math.abs(i - current) <= 1) {
                            pages.push({ type: 'page', page: i, current: i === current, key: 'page-' + i });
                        } else if (Math.abs(i - current) === 2) {
                            pages.push({ type: 'dots', text: '...', key: 'dots-' + i });
                        }
                    }
                    // Удаляем дубликаты троеточий
                    let result = [];
                    pages.forEach(item => {
                        if (item.type === 'dots') {
                            if (result.length === 0 || result[result.length - 1].type !== 'dots') {
                                result.push(item);
                            }
                        } else {
                            result.push(item);
                        }
                    });
                    return result;
                }
            }
        }
    </script>
@endsection
