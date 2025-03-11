@extends('layouts.public', ['kzLink' => 'ads/', 'ruLink' => 'ads/', 'enLink' => 'ads/'])

@section('content')
    <div class="container mx-auto px-4">
        <div class="mt-[40px]">
            <x-breadcrumbs :items="[
                ['title' => __('public.pageHome'), 'url' => route('home')],
                ['title' => __('public.ads')],
            ]"/>
        </div>

        <div class="mt-[40px] pb-[50px] xl:pb-[100px]">
            <div class="flex flex-col lg:flex-row items-start mt-[30px] md:mt-[60px]">
                @foreach($ads as $item)
                    <div
                        class="bg-white hover:bg-custom-main group transition-colors duration-300 p-[20px] rounded-[20px] w-full lg:w-1/3 lg:mx-[5px] text-[14px] my-[8px] lg-my-[0px]">
                        <div class="flex items-center mb-[10px]">
                            <i class="fad fa-calendar-alt text-custom-main mr-[8px] group-hover:text-white"></i>
                            <span class="group-hover:text-white">{{ $item->formatted_date }}</span>
                        </div>
                        <div class="flex items-center h-[100px] overflow-hidden font-semibold">
                            <a href="{{ route('ads.show', $item->getProperty('slug')) }}" class="group-hover:text-white">
                                {{ $item->getProperty('title') }}
                            </a>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
@endsection
