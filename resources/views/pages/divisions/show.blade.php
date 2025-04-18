@extends('layouts.public', ['kzLink' => 'structure/' . $item->slug_kz, 'ruLink' => 'structure/' . $item->slug_ru, 'enLink' => 'structure/' . $item->slug_en])

@section('content')
    <div class="container mx-auto px-2">
        <div class="mt-[40px] md:mt-[60px] xl:mt-[40px]">
            <x-breadcrumbs :items="[
                ['title' => __('public.pageHome'), 'url' => route('home')],
                ['title' => __('public.structure'), 'url' => route('structure.index')],
                ['title' => $item->getProperty('name')],
            ]"/>
        </div>
        <x-mobile-structure-menu :item="$item" title="{{ __('public.structure') }}"/>
    </div>
    <div class="mt-[40px] pb-[50px] xl:pb-[100px]">
        <div class="container mx-auto px-2 lg:max-w-full 2xl:px-[120px]">
            <div class="bg-white p-[20px] rounded-[15px] shadow-md">
                <div class="flex justify-between">
                    <div class="flex-1 mr-[0px] lg:mr-[20px] 2xl:mr-[40px]">
                        <div x-data="{ activeTab: 'info' }">
                            <div class="bg-[var(--color-halftone)] px-4 md:px-0 py-[6px] rounded-[10px] flex flex-col md:flex-row flex-wrap items-center">
                                <div @click="activeTab = 'info'"
                                     :class="activeTab === 'info' ? 'bg-[var(--color-main)] text-white' : 'bg-gray-200 text-black'"
                                     class="flex-1 w-full mb-2 md:mb-0 py-[12px] rounded-[10px] font-semibold text-center md:mx-[6px] cursor-pointer">
                                    Основная информация
                                </div>
                                @if(!empty($item->staff))
                                    <div @click="activeTab = 'staff'"
                                         :class="activeTab === 'staff' ? 'bg-[var(--color-main)] text-white' : 'bg-gray-200 text-black'"
                                         class="flex-1 w-full mb-2 md:mb-0 py-[12px] rounded-[10px] font-semibold text-center md:mx-[6px] cursor-pointer">
                                        {{ __('public.staff') }}
                                    </div>
                                @endif
                                @if(!empty(json_decode($item->getProperty('documents'))))
                                    <div @click="activeTab = 'documents'"
                                         :class="activeTab === 'documents' ? 'bg-[var(--color-main)] text-white' : 'bg-gray-200 text-black'"
                                         class="flex-1 w-full mb-2 md:mb-0 py-[12px] rounded-[10px] font-semibold text-center md:mx-[6px] cursor-pointer">
                                        Документы
                                    </div>
                                @endif
                            </div>

                            <div class="mt-[20px]">
                                <div x-show="activeTab === 'info'" x-cloak>
                                    @include('pages.faculties.components.information')
                                </div>

                                <div x-show="activeTab === 'staff'" x-cloak>
                                    @include('pages.faculties.components.staff')
                                </div>

                                <div x-show="activeTab === 'documents'" x-cloak>
                                    @include('pages.faculties.components.documents')
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="hidden lg:block lg:w-[400px] 2xl:w-[625px] p-[20px] flex-shrink-0 border-l px-[20px]">
                        <div>
                            @if($item->parent)
                                <div>
                                    <a href="{{ route('structure.show', $item->parent->getProperty('slug')) }}"
                                       class="font-semibold">
                                        {{ $item->parent->getProperty('name') }}
                                    </a>
                                </div>
                                <div class="pl-[20px]">
                                    @include('custom-components.divisions-list', ['divisions' => $item->parent->children, 'currentId' => $item->id])
                                </div>
                            @else
                                <div>
                                    <span
                                        class="text-[var(--color-main)] font-semibold">{{ $item->getProperty('name') }}</span>
                                </div>
                                <div class="pl-[20px]">
                                    @include('custom-components.divisions-list', ['divisions' => $item->children, 'currentId' => $item->id])
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('styles')
    <style>
        table, tr, td {
            border: 1px solid #000;
        }

        td {
            padding: 5px 10px;
        }

        .content p img {
            margin: 0 auto;
        }

        /*.content {*/
        /*    font-family: 'Open Sans', serif !important;*/
        /*}*/

        /*.content, .content p, .content span {*/
        /*    font-size: 1rem !important;*/
        /*}*/
    </style>
@endpush
