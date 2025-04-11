@extends('layouts.public', ['kzLink' => 'compliance/', 'ruLink' => 'compliance/', 'enLink' => 'compliance/'])

@section('content')

    <div class="w-full py-[60px] h-auto xl:h-[600px] 2xl:h-[700px] overflow-hidden relative">
        <div class="w-full h-full absolute top-0 left-0 bg-[var(--color-main)]">
            <img src="/{{ $item->page_preview }}" alt="/{{ $item->getProperty('title') }}"
                 class="w-full h-full object-cover absolute top-0 left-0 z-[2]">
            <div class="w-full h-full bg-[var(--color-main)] opacity-40 absolute top-0 left-0 z-[2]"></div>
        </div>
        <div class="relative flex justify-center items-center h-full">
            <div class="container mx-auto px-4">
                <div class="relative w-full z-[3]">
                    <div class="text-white text-xl md:text-[36px] font-bold">
                        <h1>{{ $item->getProperty('title') }}</h1>
                    </div>
                    <div class="text-md md:text-[18px] text-white mt-[20px] max-w-[500px]">
                        {{ $item->getProperty('description') }}
                    </div>
                    <div class="flex flex-wrap xl:flex-nowrap items-center w-full mt-[40px]">
                        @foreach(json_decode($item->getProperty('cards')) as $card)
                            @if($card->title !== null)
                                <x-link-card url="{{ $card->file ?? $card->link }}"
                                             title="{{ $card->subtitle }}"
                                             subtitle="{{ $card->title }}"/>
                            @endif
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="container mx-auto px-4">
        @include('pages.komplaens.slider.slider', ['gallery' => $item->images])
    </div>
    <div class="container mx-auto px-4 py-[50px] xl:py-[100px]">
        <div class="">
            @if($item->documents_processed)
                <div class="flex flex-wrap">
                    <div class="flex-1 md:mr-[30px]">
                        <div class="text-[24px] md:text-[36px] font-bold">
                            <h3>{{ __('public.documents')  }}</h3>
                        </div>
                        <div class="mt-[30px]">
                            @foreach($item->documents_processed as $document)
                                <div class="my-[15px]">
                                    <div>
                                        <x-info-card title="{{ $document['filename'] }}"
                                                     link="/{{ $document['path'] }}"/>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            @endif
        </div>
    </div>
@endsection
