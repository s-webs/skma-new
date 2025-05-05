@extends('layouts.public', ['kzLink' => 'dis-sovet/reports/', 'ruLink' => 'dis-sovet/reports/', 'enLink' => 'dis-sovet/reports/'])

@section('content')
    <div class="container mx-auto px-4 mb-[60px]">
        <div class="mt-[40px] md:mt-[60px] xl:mt-[40px]">
            <x-breadcrumbs :items="[
                ['title' => __('public.pageHome'), 'url' => route('home')],
                ['title' => __('dissovet.dissertation_council'), 'url' => route('dissovet.index')],
                ['title' => __('dissovet.dissertation_council_documents'), 'url' => route('dissovet.documents')],
                ['title' => __('dissovet.reports'), 'url' => route('dissovet.reports')],
            ]"/>
        </div>
        <div class="mt-[60px] pb-[50px] py-[20px] xl:pb-[100px] bg-white shadow-md rounded-[15px] px-4 2xl:px-28">
            <div>
                <x-page-title>{{ __('dissovet.reports') }}</x-page-title>
            </div>
            <div class="mt-[70px]">
                @foreach($documents as $document)
                    <div class="mt-[20px]">
                        <a href="/{{ $document->getProperty('file') }}"
                           class="p-[29px] bg-[var(--color-halftone)] rounded-[30px] flex items-center group hover:bg-[var(--color-main)] transition-all duration-300"
                           target="_blank">
                            <div
                                class="bg-[var(--color-main)] w-[26px] h-[26px] rounded-full mr-[13px] group-hover:bg-white transition-all duration-300"></div>
                            <span
                                class="font-semibold group-hover:text-white transition-all duration-300">{{ $document->getProperty('title') }}</span>
                        </a>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
@endsection
