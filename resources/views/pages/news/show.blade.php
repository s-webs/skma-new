@extends('layouts.public', ['kzLink' => 'news/' . $item->slug_kz, 'ruLink' => 'news/' . $item->slug_ru, 'enLink' => 'news/' . $item->slug_en])

@section('content')
    <div>
        <div class="container mx-auto px-4 2xl:px-28">
            <div class="mt-[40px]">
                <span class="mr-[10px] font-semibold"><a href="{{ route('home') }}"
                                                         class="text-custom-main hover:text-[#5E18AF] transition-all duration-300">Главная</a></span>
                <span class="mr-[10px]"><i class="fal fa-angle-right text-custom-main"></i></span>
                <span class="mr-[10px] font-semibold"><a href="{{ route('news.index') }}"
                                                         class="text-custom-main hover:text-[#5E18AF] transition-all duration-300">Новости</a></span>
                <span class="mr-[10px]"><i class="fal fa-angle-right text-custom-main"></i></span>
                <span class="font-semibold">{{ $item->getProperty('title') }}</span>
            </div>
            <div class="flex flex-col md:flex-row items-start md:items-center justify-between mt-[60px]">
                <div class="">
{{--                    <a href="##"--}}
{{--                       class="py-[12px] px-[14px] border bg-white text-custom-main rounded-[10px] hover:bg-custom-main duration-300 transition-all hover:text-white">--}}
{{--                        Подразделение--}}
{{--                    </a>--}}
                </div>
                <div class="flex items-center">
                    <div class="flex items-center mr-[20px]">
                        <i class="fad fa-calendar-alt text-custom-secondary"></i><span
                            class="ml-[6px]">{{ $item->formatted_date }}</span>
                    </div>
                    <div class="flex items-center mr-[20px]">
                        <i class="fas fa-eye text-custom-secondary"></i><span
                            class="ml-[6px]">{{ $item->getProperty('views') }}</span>
                    </div>
                    <div class="flex items-center mr-[20px]">
                        <i class="fas fa-heart text-custom-secondary"></i><span
                            class="ml-[6px]">{{ $item->likes->count() }}</span>
                    </div>
                    <div class="flex items-center">
                        <i class="fas fa-comment text-custom-secondary"></i><span
                            class="ml-[6px]">{{ $item->comments->count() }}</span>
                    </div>
                </div>
            </div>
            <div class="mt-[20px] border-t py-[30px]">
                <h1 class="text-lg xl:leading-[60px]  2xl:text-[42px] font-bold">{{ $item->getProperty('title') }}</h1>
            </div>
            @if($item->images)
            <div class="mt-[40px] w-full h-[300px] xl:h-[600px] rounded-[30px] overflow-hidden border-[10px] border-custom-main/25">
                <div class="swiper news-slider w-full h-full">
                    <div class="swiper-wrapper w-full h-full">
                        @foreach($item->images as $image)
                            <div class="swiper-slide w-full h-full">
                                <img src="/{{ $image }}" alt="{{ $image }}" class="w-full h-full object-cover">
                            </div>
                        @endforeach
                    </div>
                    <div class="swiper-pagination"></div>
                </div>
            </div>
            @else
                <div class="mt-[40px] w-full h-[300px] xl:h-[600px] rounded-[30px] overflow-hidden border-[10px] border-custom-main/25">
                    <img src="{{ $item->getProperty('preview') }}" alt="{{ $item->getProperty('title') }}" class="object-cover w-full h-full">
                </div>
            @endif
            <div class="content mt-[30px] pt-[30px] border-t">
                {!! $item->getProperty('text') !!}
            </div>
            {{--            <div class="mt-[30px]">--}}
            {{--                <a href="##" class="py-[12px] px-[30px] rounded-full text-custom-main hover:bg-custom-main hover:text-white mr-[10px] duration-300 transition-all">Теги</a>--}}
            {{--                <a href="##" class="py-[12px] px-[30px] rounded-full text-custom-main hover:bg-custom-main hover:text-white mr-[10px] duration-300 transition-all">Теги</a>--}}
            {{--                <a href="##" class="py-[12px] px-[30px] rounded-full text-custom-main hover:bg-custom-main hover:text-white mr-[10px] duration-300 transition-all">Теги</a>--}}
            {{--            </div>--}}
            <div class="mt-[60px] pb-[60px]">
                <form action="{{ route('like.store', $item->id)  }}" method="post">
                    @csrf
                    @if($item->isLikedBy(Auth::id()))
                        <button type="submit"
                                class="text-[16px] border-2 px-[14px] py-[10px] rounded-full text-secondary bg-red-500 hover:bg-red-700 text-white hover:text-white">
                            <i class="fal fa-heart mr-[2.5px]"></i>
                            <span>Нравится</span>
                        </button>
                    @else
                        <button type="submit"
                                class="text-[16px] border-2 px-[14px] py-[10px] rounded-full text-secondary hover:bg-red-500 hover:text-white">
                            <i class="fal fa-heart mr-[2.5px]"></i>
                            <span>Нравится</span>
                        </button>
                    @endif
                </form>
            </div>
            <div class="py-[60px] border-t">
                <div class="text-[24px] font-semibold">Комментарии (2)</div>
                <div class="mt-[24px]">
                    <form action="{{ route('comment.store', $item->id) }}" method="post">
                        @csrf
                        <textarea name="message" placeholder="Напишите комментарий"
                                  class="resize-none w-full p-[16px] pb-[50px] rounded-[10px]"></textarea>
                        <button type="submit"
                                class="bg-custom-main hover:bg-[#5E18AF] transition-all duration-300 text-white px-[15px] py-[10px] mt-[10px] rounded-[5px]">
                            Опубликовать
                        </button>
                    </form>
                </div>
                <div class="text-[16px] mt-[60px]">
                    @foreach($item->comments as $comment)
                        <div class="mb-[30px]">
                            <div class="font-semibold flex items-center justify-between">
                                <div>{{ $comment->user->name }}</div>
                                @if($comment->isOwnedBy(Auth::id()))
                                    <div>

                                        <form action="{{ route('comment.delete', $comment->id) }}" method="post">
                                            @method('DELETE')
                                            @csrf
                                            <button type="submit" class="text-red-400"><i class="fal fa-trash"></i>
                                                Удалить
                                            </button>
                                        </form>
                                    </div>
                                @endif
                            </div>
                            <div class="mt-[10px]">{{ $comment->comment }}</div>
                        </div>
                    @endforeach
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
