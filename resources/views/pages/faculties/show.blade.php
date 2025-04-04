@extends('layouts.public', ['kzLink' => 'faculties/' . $item->slug_kz, 'ruLink' => 'faculties/' . $item->slug_ru, 'enLink' => 'faculties/' . $item->slug_en])

@section('content')
    <div class="container mx-auto px-2">
        <div class="mt-[40px] md:mt-[60px] xl:mt-[40px]">
            <x-breadcrumbs :items="[
                ['title' => __('public.pageHome'), 'url' => route('home')],
                ['title' => __('public.faculties'), 'url' => route('faculties.index')],
                ['title' => $item->getProperty('name')],
            ]"/>
        </div>
        @include('pages.faculties.components.structureMobileMenu')
    </div>

    <div class="mt-[40px] pb-[50px] xl:pb-[100px]">
        <div class="container mx-auto px-2 lg:max-w-full 2xl:px-[120px]">
            <div class="bg-white p-[20px] rounded-[15px] shadow-md">
                <div class="flex justify-between">
                    <div class="flex-1 mr-[0px] lg:mr-[20px] 2xl:mr-[40px]">
                        <div x-data="{ activeTab: 'info' }">
                            <div class="bg-[var(--color-halftone)] py-[6px] rounded-[10px] flex flex-wrap items-center">
                                <div @click="activeTab = 'info'"
                                     :class="activeTab === 'info' ? 'bg-[var(--color-main)] text-white' : 'bg-gray-200 text-black'"
                                     class="flex-1 py-[12px] rounded-[10px] font-semibold text-center mx-[6px] cursor-pointer">
                                    Основная информация
                                </div>
                                @if(!empty(json_decode($item->getProperty('documents'))))
                                    <div @click="activeTab = 'documents'"
                                         :class="activeTab === 'documents' ? 'bg-[var(--color-main)] text-white' : 'bg-gray-200 text-black'"
                                         class="flex-1 py-[12px] rounded-[10px] font-semibold text-center mx-[6px] cursor-pointer">
                                        Документы
                                    </div>
                                @endif
                                @if($item->umkd)
                                    <div @click="activeTab = 'umkd'"
                                         :class="activeTab === 'umkd' ? 'bg-[var(--color-main)] text-white' : 'bg-gray-200 text-black'"
                                         class="flex-1 py-[12px] rounded-[10px] font-semibold text-center mx-[6px] cursor-pointer">
                                        УМКД
                                    </div>
                                @endif
                                <div @click="activeTab = 'portfolio'"
                                     :class="activeTab === 'portfolio' ? 'bg-[var(--color-main)] text-white' : 'bg-gray-200 text-black'"
                                     class="flex-1 py-[12px] rounded-[10px] font-semibold text-center mx-[6px] cursor-pointer">
                                    Портфолио
                                </div>
                            </div>

                            <div class="mt-[20px]">
                                <div x-show="activeTab === 'info'" x-cloak>
                                    @include('pages.faculties.components.information')
                                </div>

                                <div x-show="activeTab === 'documents'" x-cloak>
                                    @include('pages.faculties.components.documents')
                                </div>

                                <div x-show="activeTab === 'umkd'" x-cloak>
                                    @include('pages.faculties.components.umkd')
                                </div>

                                <div x-show="activeTab === 'portfolio'" x-cloak>
                                    @include('pages.faculties.components.portfolio')
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="hidden lg:block lg:w-[400px] 2xl:w-[625px] p-[20px] flex-shrink-0 border-l px-[20px]">
                        @include('pages.faculties.components.structureMenu')
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
