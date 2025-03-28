@extends('layouts.public', ['kzLink' => 'for-the-student/', 'ruLink' => 'for-the-student/', 'enLink' => 'for-the-student/'])

@section('content')
    <div class="w-full py-[60px] h-auto xl:h-[600px] 2xl:h-[700px] overflow-hidden relative">
        <div class="w-full h-full absolute top-0 left-0 bg-[var(--color-main)]">
            <img src="/assets/images/for-students.jpg" alt="/assets/images/for-students.jpg"
                 class="w-full h-full object-cover absolute top-0 left-0 z-[2]">
            <div class="w-full h-full bg-[var(--color-main)] opacity-40 absolute top-0 left-0 z-[2]"></div>
        </div>
        <div class="relative flex justify-center items-center h-full">
            <div class="container mx-auto px-4">
                <div class="relative w-full z-[3]">
                    <div class="text-white text-xl md:text-[36px] font-bold">
                        <h1>{{ __('student.dear_student_welcome_skma') }}</h1>
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
    <div class="">
        @include('pages.home.components.services', compact('services'))
    </div>
    <div class="container mx-auto px-4 py-[50px] xl:py-[100px]">
        <div class="text-[24px] md:text-[36px] font-bold">
            <h3>Расписание</h3>
        </div>
    </div>
@endsection
