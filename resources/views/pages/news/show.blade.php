@extends('layouts.public', ['kzLink' => 'news/' . $item->slug_kz, 'ruLink' => 'news/' . $item->slug_ru, 'enLink' => 'news/' . $item->slug_en])

@section('content')
    <div>
        <div class="container mx-auto px-4 2xl:px-28 bg-white py-[40px] my-[40px] rounded-[15px] shadow-md">
            <div class="">
                <x-breadcrumbs :items="[
                ['title' => __('public.pageHome'), 'url' => route('home')],
                ['title' => __('home.academyNews'), 'url' => route('news.index')],
                ['title' => $item->getProperty('short')],
            ]"/>
            </div>
            <div
                class="flex flex-col md:flex-row items-start md:items-center justify-between mt-[30px] xl:mt-[60px] border-b pb-[15px]">
                <div class="">
                    {{--                    <a href="##"--}}
                    {{--                       class="py-[12px] px-[14px] border bg-white text-[var(--color-main)] rounded-[10px] hover:bg-[var(--color-main)] duration-300 transition-all hover:text-white">--}}
                    {{--                        Подразделение--}}
                    {{--                    </a>--}}
                </div>
                <div class="flex items-center">
                    <div class="flex items-center mr-[20px]">
                        <i class="fad fa-calendar-alt text-[var(--color-secondary)]"></i><span
                            class="ml-[6px]">{{ $item->formatted_date }}</span>
                    </div>
                    <div class="flex items-center mr-[20px]">
                        <i class="fas fa-eye text-[var(--color-secondary)]"></i><span
                            class="ml-[6px]">{{ $item->getProperty('views') }}</span>
                    </div>
                    <div class="flex items-center mr-[20px]">
                        <i class="fas fa-heart text-[var(--color-secondary)]"></i><span
                            class="ml-[6px]">{{ $item->likes->count() }}</span>
                    </div>
                    <div class="flex items-center">
                        <i class="fas fa-comment text-[var(--color-secondary)]"></i><span
                            class="ml-[6px]">{{ $item->comments->count() }}</span>
                    </div>
                </div>
            </div>
            <div class="md:mt-[20px] py-[10px] xl:py-[30px] max-w-[910px] mx-auto">
                <x-page-title>{{ $item->getProperty('title') }}</x-page-title>
            </div>
            <div class="max-w-[910px] mx-auto mt-[40px]">
                @if($item->images)
                    <div
                        class="w-full h-[300px] xl:h-[600px] rounded-[30px] overflow-hidden">
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
                    <div
                        class="w-full h-[300px] xl:h-[600px] rounded-[30px] overflow-hidden">
                        <img src="{{ $item->getProperty('preview') }}" alt="{{ $item->getProperty('title') }}"
                             class="object-cover w-full h-full">
                    </div>
                @endif
            </div>
            <div class="content mt-[30px] pt-[30px] border-t max-w-[910px] mx-auto">
                {!! $item->getProperty('text') !!}
            </div>
            {{--            <div class="mt-[30px]">--}}
            {{--                <a href="##" class="py-[12px] px-[30px] rounded-full text-[var(--color-main)] hover:bg-[var(--color-main)] hover:text-white mr-[10px] duration-300 transition-all">Теги</a>--}}
            {{--                <a href="##" class="py-[12px] px-[30px] rounded-full text-[var(--color-main)] hover:bg-[var(--color-main)] hover:text-white mr-[10px] duration-300 transition-all">Теги</a>--}}
            {{--                <a href="##" class="py-[12px] px-[30px] rounded-full text-[var(--color-main)] hover:bg-[var(--color-main)] hover:text-white mr-[10px] duration-300 transition-all">Теги</a>--}}
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
            <div class="pt-[60px] border-t">
                <div class="text-[24px] font-semibold">{{ __('public.comments') }} ({{ $item->comments->count() }})
                </div>
                <div class="mt-[24px]">
                    <form action="{{ route('comment.store', $item->id) }}" method="post">
                        @csrf
                        <textarea name="message" placeholder="Напишите комментарий"
                                  class="resize-none w-full p-[16px] pb-[50px] rounded-[10px]"></textarea>
                        <button type="submit"
                                class="bg-[var(--color-main)] hover:bg-[var(--color-extra)] transition-all duration-300 text-white px-[15px] py-[10px] mt-[10px] rounded-[5px]">
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
            font-size: 18px;
        }

        .content p img {
            margin: 30px auto;
        }
    </style>
@endpush
