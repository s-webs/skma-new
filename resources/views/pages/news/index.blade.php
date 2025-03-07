@extends('layouts.public', ['kzLink' => 'news/', 'ruLink' => 'news/', 'enLink' => 'news/'])

@section('content')
    <div class="container mx-auto px-4 2xl:px-28">
        <div class="mt-[40px]">
            <x-breadcrumbs :items="[
                ['title' => __('public.pageHome'), 'url' => route('home')],
                ['title' => __('home.academyNews')]
            ]"/>
        </div>
        <div>
            <x-page-title>{{ __('home.academyNews') }}</x-page-title>
        </div>
        {{--        <div></div>--}}
        {{--        <div></div>--}}
        <div class="mt-[40px]">
            <div class="flex flex-wrap md:gap-[3px] lg:gap-0 flex-start xl:justify-center">
                @foreach($news as $item)
                    <div class="w-full md:w-[45%] lg:w-[403px] my-[10px] md:my-[15px] md:mx-[15px] group">
                        <div class="rounded-[20px] overflow-hidden">
                            <div class="w-full h-[269px]">
                                <a href="{{ route('news.show', $item->getProperty('slug')) }}">
                                    <img src="{{ $item->getProperty('preview') }}"
                                         alt="{{ $item->getProperty('title') }}"
                                         class="w-full h-full object-cover group-hover:scale-110 transition-all duration-300">
                                </a>
                            </div>
                            <div></div>
                        </div>
                        <div class="mt-[20px]">
                            <a href="{{ route('news.show', $item->getProperty('slug')) }}"
                               class="font-semibold group-hover:text-custom-main transition-all duration-300">
                                {{ $item->getProperty('title') }}
                            </a>
                        </div>
                    </div>
                @endforeach
            </div>
            <div class="pb-[50px] xl:pb-[100px] pt-[40px]">
                {{ $news->links() }}
            </div>
        </div>
    </div>
@endsection
