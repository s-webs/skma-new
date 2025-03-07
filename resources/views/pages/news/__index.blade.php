@extends('layouts.public', ['kzLink' => 'news/', 'ruLink' => 'news/', 'enLink' => 'news/'])

@section('content')
    @include('custom-components.home-heading', ['title' => __('home.academyNews')])
    <div class="flex justify-between">
        <div class="basis-2/3">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mt-8">
                @foreach($news as $item)
                    <div class="bg-white rounded-md shadow-md">
                        <div class="w-full rounded-t-md overflow-hidden h-48">
                            <a href="{{ route('news.show', $item->getProperty('slug')) }}">
                            <img class="w-full h-full object-cover border-b" src="{{ $item->preview_ru }}"
                                 alt="{{ $item->getProperty('title') }}">
                            </a>
                        </div>
                        <div class="text-md p-4 border-b h-24">
                            <a href="{{ route('news.show', $item->getProperty('slug')) }}">{{ $item->getProperty('title') }}</a>
                        </div>
                        <div class="p-4">
                            <div class="flex justify-between text-sm">
                                <div class="text-primary-light"><i
                                        class="fal fa-calendar"></i> {{$item->created_at}}</div>
                                <div class="flex text-sm">
                                    <div class="text-primary-light mr-2"><i
                                            class="fal fa-eye"></i> {{$item->getProperty('views')}}
                                    </div>
                                    @if($item->isLikedBy(Auth::id()))
                                        <div class="text-primary-light mr-2"><i class="fas text-red-500 fa-heart"></i> {{ $item->likes->count() }}</div>
                                    @else
                                        <div class="text-primary-light mr-2"><i class="fal fa-heart"></i> {{ $item->likes->count() }}</div>
                                    @endif
                                    <div class="text-primary-light"><i class="fal fa-comment"></i> {{ $item->comments->count() }}</div>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
        <div class="basis-1/4 border">ФИЛЬТРЫ</div>
    </div>
@endsection
