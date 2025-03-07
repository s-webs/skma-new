@extends('layouts.public', ['kzLink' => 'news/' . $item->slug_kz, 'ruLink' => 'news/' . $item->slug_ru, 'enLink' => 'news/' . $item->slug_en])

@section('content')
    <div class="">
        <div class="bg-white p-4 rounded-md mb-4 xl:hidden">
            <div>
                <h1 class="text-xl md:text-2xl font-bold py-4 text-primary-main">{{ $item->getProperty('title') }}</h1>
            </div>
            <div class="border-t-2 text-sm py-2 flex">
                <div class="text-primary-main mr-4"><i class="fal fa-calendar"></i> {{$item->created_at}}</div>
                <div class="text-primary-main mr-4"><i class="fal fa-eye"></i> {{$item->getProperty('views')}}</div>
                <form action="{{ route('like.store', $item->id)  }}" method="post" class="text-primary-main mr-4">
                    @csrf
                    @if($item->isLikedBy(Auth::id()))
                        <button type="submit"><i class="fas text-red-500 fa-heart"></i> {{ $item->likes->count() }}
                        </button>
                    @else
                        <button type="submit"><i class="fal fa-heart"></i> {{ $item->likes->count() }}</button>
                    @endif
                </form>
                <div class="text-primary-main mr-4"><i class="fal fa-comment"></i> {{ $item->comments->count() }}</div>
            </div>
        </div>
        <div class="w-full h-[200px] md:h-[300px] xl:h-[500px] relative rounded-md overflow-hidden">
            <div
                class="w-full h-full bg-gradient-to-r from-purple-500 via-indigo-500 to-blue-500 opacity-20 absolute top-0 left-0 z-10">
            </div>
            <img class="w-full h-full object-cover absolute" src="{{ $item->preview_ru }}" alt="">
            <div
                class="absolute z-20 left-0 bottom-16 pl-16 pr-8 py-8 rounded-tr-md rounded-br-md bg-black bg-opacity-70 backdrop-blur-sm hidden xl:block">
                <div>
                    <h1 class="text-3xl font-bold py-4 text-white">{{ $item->getProperty('title') }}</h1>
                </div>
                <div class="border-t-2 py-2 flex">
                    <div class="text-white mr-4"><i class="fal fa-calendar"></i> {{$item->created_at}}</div>
                    <div class="text-white mr-4"><i class="fal fa-eye"></i> {{$item->getProperty('views')}}</div>
                    <form action="{{ route('like.store', $item->id)  }}" method="post" class="text-white mr-4">
                        @csrf
                        @if($item->isLikedBy(Auth::id()))
                            <button type="submit"><i class="fas text-red-500 fa-heart"></i> {{ $item->likes->count() }}
                            </button>
                        @else
                            <button type="submit"><i class="fal fa-heart"></i> {{ $item->likes->count() }}</button>
                        @endif
                    </form>
                    <div class="text-white mr-4"><i class="fal fa-comment"></i> {{ $item->comments->count() }}</div>
                </div>
            </div>
        </div>
        <div class="flex gap-4 justify-between mt-8">
            <div class="">
{{--                <div>--}}
{{--                    SLIDER--}}
{{--                </div>--}}
                <div class="px-5 py-4 bg-white rounded-md">
                    <div class="content">{!! $item->getProperty('text') !!}</div>
                </div>
                <div class="mt-8 bg-white rounded-md p-4">
                    <div class="text-xl pb-4 border-b-2">Комментарии: {{ $item->comments->count() }}</div>
                    <div class="mt-8">
                        @foreach($item->comments as $comment)
                            <div class="border rounded-md shadow-sm p-4 my-2">
                                <div class="flex items-center">
                                    <div class="mr-4">
                                        @if($comment->user->avatar)
                                            <img class="w-16 h-16 rounded-full object-cover"
                                                 src="{{ $comment->user->avatar }}"
                                                 alt="">
                                        @else
                                            <img class="w-16 h-16 rounded-full object-cover"
                                                 src="/assets/images/default_user.webp"
                                                 alt="">
                                        @endif
                                    </div>
                                    <div>{{ $comment->user->name }}</div>
                                </div>
                                <div class="my-4">{{ $comment->comment }}</div>
                                <div class="flex justify-between items-center text-sm text-gray-400 pt-2 border-t">
                                    <div class="mr-4"><i class="fal fa-calendar"></i> {{ $comment->created_at }}</div>
                                    @if($comment->isOwnedBy(Auth::id()))
                                        <form action="{{ route('comment.delete', $comment->id) }}" method="post">
                                            @method('DELETE')
                                            @csrf
                                            <button type="submit" class="text-red-400"><i class="fal fa-trash"></i>
                                                Удалить
                                            </button>
                                        </form>
                                    @endif
                                </div>
                            </div>
                        @endforeach
                    </div>
                    <div class="mt-8">
                        <form action="{{ route('comment.store', $item->id) }}" method="post">
                            @csrf
                            <div class="mb-4 border border-gray-300 rounded-lg bg-gray-50 ">
                                <div class="px-4 py-2 bg-white rounded-t-lg ">
                                    <label for="comment">Оставьте комментарий</label>
                                    <textarea name="message" id="comment" rows="4"
                                              class="w-full px-0 text-sm text-gray-700 bg-white border-0 focus:ring-0 "
                                              placeholder="Напишите комментарий..." required></textarea>
                                </div>
                                <div class="flex items-center justify-between px-3 py-2 border-t border-gray-200">
                                    <button type="submit"
                                            class="inline-flex items-center py-2.5 px-4 text-xs font-medium text-center text-white bg-primary-main rounded-lg focus:ring-4 focus:ring-blue-200 hover:bg-primary-secondary">
                                        Отправить
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
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
    </style>
@endpush
