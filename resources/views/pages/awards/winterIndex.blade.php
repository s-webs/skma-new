@extends('layouts.winterLayout', ['kzLink' => 'awards/', 'ruLink' => 'awards/', 'enLink' => 'awards/'])

@section('content')
    <div class="container mx-auto px-4">
        <div class="mt-[40px]">
            <x-breadcrumbs :items="[
                ['title' => __('public.pageHome'), 'url' => route('home')],
                ['title' => __('home.awardsAchievements')],
            ]"/>
        </div>
        <div class="">
            <x-page-title>{{ __('home.awardsAchievements') }}</x-page-title>
        </div>
        <div class="mt-[40px] pb-[50px] xl:pb-[100px]">
            <div id="lightgallery" class="columns-2 md:columns-3 lg:columns-4 gap-4 space-y-4">
                @foreach ($awards as $image)
                    <a href="/{{ $image->getProperty('image') }}" data-lg-size="1600-2400" class="block overflow-hidden rounded-lg">
                        <img alt="{{ $image->getProperty('image') }}" src="/{{ $image->getProperty('image') }}" class="w-full h-auto object-cover rounded-lg shadow-lg transition-transform duration-300 hover:scale-105"/>
                    </a>
                @endforeach
            </div>
        </div>
    </div>
@endsection
