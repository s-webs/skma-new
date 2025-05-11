@extends('layouts.public', ['kzLink' => 'pages/' . $item->slug_kz, 'ruLink' => 'pages/' . $item->slug_ru, 'enLink' => 'pages/' . $item->slug_en])

@section('content')
    <div>
        <div class="container mx-auto px-4 2xl:px-28 bg-white py-[40px] my-[40px] rounded-[15px] shadow-md">
            <div class="">
                <x-breadcrumbs :items="[
                ['title' => __('public.pageHome'), 'url' => route('home')],
                ['title' => $item->getProperty('short')],
            ]"/>
            </div>
            <div
                class="flex flex-col md:flex-row items-start md:items-center justify-between mt-[30px] xl:mt-[60px] border-b pb-[15px]">
                <div class="flex items-center">
                    <div class="flex items-center mr-[20px]">
                        <i class="fad fa-calendar-alt text-[var(--color-secondary)]"></i><span
                            class="ml-[6px]">{{ $item->formatted_date }}</span>
                    </div>
                </div>
            </div>
            <div class="md:mt-[20px] py-[10px] xl:py-[30px] max-w-[910px] mx-auto">
                <x-page-title>{{ $item->getProperty('name') }}</x-page-title>
            </div>
            <div class="content mt-[30px] pt-[30px] border-t max-w-[910px] mx-auto">
                {!! $item->getProperty('text') !!}
            </div>
            <div class="mt-[50px] px-[16px] pb-[16px] max-w-[910px] mx-auto">
                @foreach($item->files as $file)
                    <div class="mb-[10px]">
                        <a href="/{{ $file['path'] }}" target="_blank"
                           class="p-[20px] bg-[var(--color-halftone)] rounded-[30px] flex items-center group hover:bg-[var(--color-main)] transition-all duration-300">
                            <div
                                class="shrink-0 bg-[var(--color-main)] w-[18px] h-[18px] rounded-full mr-[8px] group-hover:bg-white transition-all duration-300"></div>
                            <span
                                class="font-semibold group-hover:text-white transition-all duration-300">{{ $file['name'] }}</span>
                        </a>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
@endsection

@push('styles')
    <style>
        .content p {
            font-size: 18px;
        }

        .content p img {
            margin: 30px auto;
        }
    </style>
@endpush
