@extends('layouts.public', ['kzLink' => 'news/' . $item->slug_kz, 'ruLink' => 'news/' . $item->slug_ru, 'enLink' => 'news/' . $item->slug_en])

@section('content')
    <div class="">
        <div class="w-full h-[500px] relative rounded-md overflow-hidden">
            <div
                class="w-full h-full bg-gradient-to-r from-purple-500 via-indigo-500 to-blue-500 opacity-20 absolute top-0 left-0 z-10">
            </div>
            <img class="w-full h-full object-cover absolute" src="{{ $item->preview_ru }}" alt="">
            <div class="absolute z-20 left-0 bottom-16 pl-16 pr-8 py-8 rounded-tr-md rounded-br-md bg-black bg-opacity-70 backdrop-blur-sm">
                <div>
                    <h1 class="text-3xl font-bold py-4 text-white">{{ $item->getProperty('title') }}</h1>
                </div>
                <div class="border-t-2 py-2 flex">
                    <div class="text-white mr-4"><i class="fal fa-calendar"></i> {{$item->created_at}}</div>
                    <div class="text-white mr-4"><i class="fal fa-eye"></i> {{$item->getProperty('views')}}</div>
                    <div class="text-white mr-4"><i class="fal fa-heart"></i> 70</div>
                    <div class="text-white mr-4"><i class="fal fa-comment"></i> 12</div>
                </div>
            </div>
        </div>
        <div class="flex gap-4 justify-between mt-8">
            <div class="basis-3/4">
                <div>
                    SLIDER
                </div>
                <div class="px-5 py-4 bg-white rounded-md">
                    <div class="content">{!! $item->getProperty('text') !!}</div>
                </div>
                <div class="mt-8 bg-white rounded-md p-4">
                    <div class="text-xl pb-4 border-b-2">Комментарии</div>
                </div>
            </div>
            <div class="basis-1/4 bg-white rounded-md p-4">options</div>
        </div>
    </div>
@endsection

@push('styles')
    <style>
        .content p {
            font-size: 1.3rem;
        }
        .content img {
            margin: 30px auto;
            text-align: center;
        }
    </style>
@endpush
