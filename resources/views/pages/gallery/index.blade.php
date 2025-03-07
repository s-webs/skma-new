@extends('layouts.public', ['kzLink' => 'gallery/', 'ruLink' => 'gallery/', 'enLink' => 'gallery/'])

@section('content')
    <div class="container mx-auto">
        <div class="mt-[40px]">
                <x-breadcrumbs :items="[
                ['title' => __('public.pageHome'), 'url' => route('home')],
                ['title' => __('home.academyGallery')],
            ]"/>
        </div>
        <div class="">
            <h1 class="text-[44px] font-bold mt-[40px]">{{ __('home.academyGallery') }}</h1>
        </div>
        <div class="mt-[40px] pb-[50px] xl:pb-[100px]">
            <div id="lightgallery" class="columns-2 md:columns-3 lg:columns-4 gap-4 space-y-4">
                @foreach ($images as $image)
                    <a href="/{{ $image->image }}" data-lg-size="1600-2400" class="block overflow-hidden rounded-lg">
                        <img alt="{{ $image->image }}" src="/{{ $image->image }}" class="w-full h-auto object-cover rounded-lg shadow-lg transition-transform duration-300 hover:scale-105"/>
                    </a>
                @endforeach
            </div>
        </div>
    </div>
@endsection
