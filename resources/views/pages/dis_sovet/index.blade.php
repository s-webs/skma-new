@extends('layouts.public', ['kzLink' => 'dis-sovet/', 'ruLink' => 'dis-sovet/', 'enLink' => 'dis-sovet/'])

@section('content')
    <div class="container mx-auto px-4 mb-[60px]">
        <div class="mt-[40px] md:mt-[60px] xl:mt-[40px]">
            <x-breadcrumbs :items="[
                ['title' => __('public.pageHome'), 'url' => route('home')],
                ['title' => __('dissovet.dissertation_council'), 'url' => route('dissovet.index')],
            ]"/>
        </div>
        <div class="mt-[60px] pb-[50px] py-[20px] xl:pb-[100px] bg-white shadow-md rounded-[15px] px-4 2xl:px-28">
            <div>
                <x-page-title>{{ __('dissovet.dissertation_council') }}</x-page-title>
            </div>
            <div class="mt-[70px]">
                <div class="mt-[20px]">
                    <a href="{{ route('dissovet.documents') }}"
                       class="p-[29px] bg-[var(--color-halftone)] rounded-[30px] flex items-center group hover:bg-[var(--color-main)] transition-all duration-300">
                        <div
                            class="bg-[var(--color-main)] w-[26px] h-[26px] rounded-full mr-[13px] group-hover:bg-white transition-all duration-300"></div>
                        <span class="font-semibold group-hover:text-white transition-all duration-300">{{ __('dissovet.dissertation_council_documents') }}</span>
                    </a>
                </div>
                <div class="mt-[20px]">
                    <a href="{{ route('dissovet.information') }}"
                       class="p-[29px] bg-[var(--color-halftone)] rounded-[30px] flex items-center group hover:bg-[var(--color-main)] transition-all duration-300">
                        <div
                            class="bg-[var(--color-main)] w-[26px] h-[26px] rounded-full mr-[13px] group-hover:bg-white transition-all duration-300"></div>
                        <span class="font-semibold group-hover:text-white transition-all duration-300">{{ __('dissovet.information_for_applicants') }}</span>
                    </a>
                </div>
                <div class="mt-[20px]">
                    <a href="{{ route('dissovet.staff') }}"
                       class="p-[29px] bg-[var(--color-halftone)] rounded-[30px] flex items-center group hover:bg-[var(--color-main)] transition-all duration-300">
                        <div
                            class="bg-[var(--color-main)] w-[26px] h-[26px] rounded-full mr-[13px] group-hover:bg-white transition-all duration-300"></div>
                        <span class="font-semibold group-hover:text-white transition-all duration-300">{{ __('dissovet.composition_of_the_dissertation_council') }}</span>
                    </a>
                </div>
                <div class="mt-[20px]">
                    <a href="{{ route('dissovet.programs') }}"
                       class="p-[29px] bg-[var(--color-halftone)] rounded-[30px] flex items-center group hover:bg-[var(--color-main)] transition-all duration-300">
                        <div
                            class="bg-[var(--color-main)] w-[26px] h-[26px] rounded-full mr-[13px] group-hover:bg-white transition-all duration-300"></div>
                        <span class="font-semibold group-hover:text-white transition-all duration-300">{{ __('dissovet.announcements_about_dissertation_defenses') }}</span>
                    </a>
                </div>
            </div>
        </div>
    </div>
@endsection
