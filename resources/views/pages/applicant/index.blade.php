@extends('layouts.public', ['kzLink' => 'for-the-applicant/', 'ruLink' => 'for-the-applicant/', 'enLink' => 'for-the-applicant/'])

@section('content')
    <div class="w-full py-[60px] h-auto xl:h-[600px] 2xl:h-[700px] overflow-hidden relative">
        <div class="w-full h-full absolute top-0 left-0 bg-[var(--color-main)]">
            <img src="/assets/images/for-applicant.png" alt="/assets/images/for-applicant.png"
                 class="w-full h-full object-cover absolute top-0 left-0 z-[3]">
            <div class="w-full h-full bg-[var(--color-main)] opacity-30 absolute top-0 left-0 z-[4]"></div>
        </div>
        <div class="relative z-[5] flex justify-center items-center h-full">
            <div class="container mx-auto px-4">
                <div class="w-full">
                    <div class="text-white text-xl md:text-[36px] font-bold">
                        <h1>{{ __('applicant.dear_entrant_welcome_skma!') }}</h1>
                    </div>
                    <div class="text-md md:text-[18px] text-white mt-[20px] max-w-[500px]">
                        {{ __('applicant.carefully_study_this_page') }}
                    </div>
                    <div class="flex flex-wrap xl:flex-nowrap items-center w-full mt-[40px]">
                        <x-link-card url="/assets/files/price-bakalavr-2025.pdf"
                                     title="{{ __('applicant.education_and_accommodation') }}"
                                     subtitle="{{ __('applicant.price_list') }}"/>
                        <x-link-card url="/assets/files/pravila-priema-bakalavr-2025.pdf"
                                     title="{{ __('applicant.admission_rules_for_training') }}"
                                     subtitle="{{ __('applicant.bakalavriat') }}"/>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="bg-[var(--color-main)] overflow-hidden mt-[60px]">
        <div class="py-[60px] flex flex-wrap items-center justify-center relative">
            @if($activeTheme->pattern_01)
                <div class="absolute hidden md:block left-[3%] uxl:left-[25%] bottom-[0px]">
                    <img src="/{{ $activeTheme->pattern_01 }}" alt="" class="w-[120px] xl:w-auto">
                </div>
            @endif

            @if($activeTheme->code === 'default')
                <div class="absolute right-[0px] bottom-[0px]">
                    <img src="/assets/images/cliparts/wave.png" alt="" class="w-auto h-[150px] xl:h-auto">
                </div>
            @else
                <div class="absolute right-[0px] bottom-[0px] h-full w-full">
                    <img src="/{{ $activeTheme->pattern_02 }}" alt="" class="w-full h-full object-cover opacity-20">
                </div>
            @endif

            @foreach($counters as $counter)
                <div
                    class="w-[160px] h-[160px] xl:w-[250px] xl:h-[250px] m-[14px] rounded-full flex flex-col justify-center items-center text-center p-5 text-white bg-white bg-opacity-30 border-[5px] xl:border-[20px] border-white border-opacity-20">
                    <div class="text-[24px] xl:text-[44px] font-semibold">
                        <span class="counter" data-count="{{ $counter->count }}">0</span>
                    </div>
                    <div class="text-[12px] xl:text-[16px] mt-[8px]">{{ $counter->getProperty('name') }}</div>
                </div>
            @endforeach
        </div>
    </div>
    <div class="my-[60px]">
        <div class="container mx-auto px-4">
            <div x-data="{ open: false }" class="overflow-hidden bg-white rounded-[15px] box-border">
                <h3 @click="open = !open"
                    class="cursor-pointer flex justify-between items-center bg-[var(--color-main)] py-[16px] px-[24px] rounded-[15px] text-white shadow-md font-semibold">
                    <span class="mr-[20px]">{{ __('applicant.list_of_offered_training_programs') }}</span>
                    <i :class="open ? 'fal fa-angle-up' : 'fal fa-angle-down'"></i>
                </h3>

                <div x-show="open" class="p-[20px]">
                    <ul class="">
                        <li class="underline mb-[16px]">В084 Сестринское дело</li>
                        <li class="underline mb-[16px]">В085 Фармация</li>
                        <li class="underline mb-[16px]">ВМ086 Медицина</li>
                        <li class="underline mb-[16px]">ВМ087 Стоматология</li>
                        <li class="underline mb-[16px]">ВМ088 Педиатрия</li>
                        <li class="underline mb-[16px]">В089 Общественное здоровье</li>
                        <li class="underline mb-[16px]">ВМ089 Медико-профилактическое дело</li>
                        <li class="underline">В072 Технология фармацевтического производства</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
@endsection
