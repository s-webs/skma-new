@extends('layouts.winterLayout', ['kzLink' => 'ads/' . $item->slug_kz, 'ruLink' => 'ads/' . $item->slug_ru, 'enLink' => 'ads/' . $item->slug_en])

@section('content')
    <div class="container mx-auto px-4">
        <div class="mt-[40px]">
            <x-breadcrumbs :items="[
                ['title' => __('public.pageHome'), 'url' => route('home')],
                ['title' => __('public.ads'), 'url' => route('ads.index')],
                ['title' => $item->getProperty('short')],
            ]"/>
        </div>

        <div class="mt-[40px] pb-[50px] py-[50px] xl:pb-[100px] bg-white shadow-md rounded-[15px] px-4 2xl:px-28">
            <div class="flex items-center justify-end">
                <div class="flex items-center mr-[20px]">
                    <i class="fad fa-calendar-alt text-winter-secondary"></i><span
                        class="ml-[6px]">{{ $item->formatted_date }}</span>
                </div>
                <div class="flex items-center mr-[20px]">
                    <i class="fas fa-eye text-winter-secondary"></i><span
                        class="ml-[6px]">{{ $item->getProperty('views') }}</span>
                </div>
            </div>
            <div class="md:mt-[20px] border-t py-[10px] xl:py-[30px]">
                <x-page-title>{{ $item->getProperty('title') }}</x-page-title>
            </div>
            <div class="content mt-[30px] pt-[30px] border-t overflow-x-auto">
                {!! $item->getProperty('description') !!}
            </div>
        </div>
    </div>
@endsection

@push('styles')
    <style>
        .content p {
            font-size: 1.1rem;
        }

        .content img {
            height: auto !important;
            margin: 30px auto;
            text-align: center;
        }

        .content table {
            border-collapse: collapse;
            width: 100%;
        }

        .content th,
        .content td {
            border: 1px solid black;
            padding: 8px;
            text-align: left;
        }

        .content th {
            background-color: #f2f2f2;
        }
    </style>
@endpush
