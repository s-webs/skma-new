@extends('layouts.public', ['kzLink' => null, 'ruLink' => null, 'enLink' => null])

@push('styles')
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css"/>
    <style>
        .custom-counter:hover img {
            opacity: 100%;
            transition-duration: 0.2s;
        }
    </style>
@endpush

@section('content')
    <div class="swiper swiper-top h-[300px] lg:h-[500px] xl:h-[640px] mySwiper rounded-md">
        <div class="swiper-wrapper">
            <div class="swiper-slide swiper-slide-top relative">
                <img class="w-full h-full object-cover" src="/assets/images/test/test-02.jpg" alt="">
                <div
                    class="w-full h-full absolute inset-0 bg-gradient-to-tr from-indigo-900 to-blue-800 z-10 opacity-40"></div>
                <div
                    class="w-full xl:w-auto absolute bottom-0 xl:bottom-20 left-0 xl:left-5 text-start z-20 bg-white bg-opacity-25 lg:bg-opacity-70 p-4 lg:p-8 rounded-none lg:rounded-md backdrop-blur-sm">
                    <div class="text-sm lg:text-4xl font-bold text-center lg:text-start text-gray-800 lg:text-black">
                        Встреча с представителем АО "Финансовый центр"
                    </div>
                    <div class="mt-4 hidden lg:block w-full xl:w-[800px]">Согласно решению заседания Правительства
                        Республики
                        Казахстан 2021-2022 учебный год для обучающихся колледжей и вузов всех направлений подготовки
                        кадров будет проходить в традиционном формате...
                    </div>
                    <div class="mt-6 text-center lg:text-start mb-8 lg:mb-0">
                        <a class="bg-primary-main hover:bg-primary-secondary duration-300 text-white px-6 py-2 rounded-md"
                           href="##">Подробнее</a>
                    </div>
                </div>
            </div>
        </div>
        <div class="swiper-button-next swiper-next-top"></div>
        <div class="swiper-button-prev swiper-prev-top"></div>
        <div class="swiper-pagination"></div>
    </div>

    @include('partials.clipart-student')

    <div class="mt-20">
        @include('custom-components.home-heading', ['title' => __('home.academyCounter')])
        <div class="grid grid-cols-2 lg:grid-cols-5 gap-6 mt-8">
            @foreach($counters as $counter)
                <div
                    class="custom-counter bg-white hover:bg-primary-main hover:text-white transition-colors duration-300 p-4 text-center h-48 flex flex-col justify-center items-center rounded-md border relative overflow-hidden">
                    <div class="text-xl h-16 z-10">{{ $counter->getProperty('name') }}</div>
                    <img class="absolute -left-10 -bottom-5 rotate-45 w-32 opacity-0"
                         src="/assets/images/logos/bg-logo-skma.png" alt="">
                    <div class="font-bold text-4xl counter mt-4 z-10" data-target="{{ $counter->count }}">0</div>
                </div>
            @endforeach
        </div>
    </div>
    <div class="mt-20">
        @include('custom-components.home-heading', ['title' => __('home.academyServices')])
        <div class="hidden lg:block">
            <div class="swiper slider-services mt-8 h-72">
                <div class="swiper-wrapper">
                    @foreach($services as $service)
                        <div class="swiper-slide overflow-hidden swiper-slide-services border rounded-md relative">
                            <a href="{{ $service->getProperty('link') }}"
                               class="block w-full h-full hover:bg-primary-main text-black hover:text-white transition-colors duration-300"
                               target="_blank">
                                <div
                                    class="absolute top-5 left-5 text-start font-bold">{{ $service->getProperty('name') }}</div>
                                <div
                                    class="bg-cyan-600 absolute w-64 h-64 rounded-full -left-8 -bottom-20 overflow-hidden border-2 border-white">
                                    <img src="{{ $service->getProperty('image') }}" alt=""
                                         class="w-full h-full object-cover">
                                </div>
                            </a>
                        </div>
                    @endforeach
                </div>
                <div class="swiper-button-next swiper-next-services"></div>
                <div class="swiper-button-prev swiper-prev-services"></div>
            </div>
        </div>
        <div class="lg:hidden">
            <div class="swiper slider-services-mobile mt-8 h-72">
                <div class="swiper-wrapper">
                    @foreach($services as $service)
                        <div class="swiper-slide overflow-hidden swiper-slide-services border rounded-md relative">
                            <a href="{{ $service->getProperty('link') }}"
                               class="block w-full h-full hover:bg-primary-main text-black hover:text-white transition-colors duration-300"
                               target="_blank">
                                <div
                                    class="absolute top-5 left-5 text-start font-bold">{{ $service->getProperty('name') }}</div>
                                <div
                                    class="bg-cyan-600 absolute w-64 h-64 rounded-full -left-8 -bottom-20 overflow-hidden border-2 border-white">
                                    <img src="{{ $service->getProperty('image') }}" alt=""
                                         class="w-full h-full object-cover">
                                </div>
                            </a>
                        </div>
                    @endforeach
                </div>
                <div class="swiper-button-next swiper-next-services"></div>
                <div class="swiper-button-prev swiper-prev-services"></div>
            </div>
        </div>
    </div>
    <div class="mt-20">
        @include('custom-components.home-heading', ['title' => __('home.academyAnnouncement'), 'link' => '##'])
        <div class="grid grid-cols-1 md:grid-cols-5 gap-6 mt-8">
            <div
                class="text-center flex flex-col h-48 justify-center items-center border rounded-md overflow-hidden relative">
                <a class="flex items-center w-full h-full bg-white text-gray-800 transition-colors duration-300 hover:bg-primary-main hover:text-white border-primary-main "
                   href="##">
                    <div class="w-full p-4 backdrop-blur-sm">
                        <div class="text-start text-xl">Встреча с вице-министром науки и высшего образования Республики
                            Казахстан
                        </div>
                    </div>
                </a>
            </div>
            <div
                class="text-center flex flex-col h-48 justify-center items-center border rounded-md overflow-hidden relative">
                <a class="flex items-center w-full h-full bg-white text-gray-800 transition-colors duration-300 hover:bg-primary-main hover:text-white border-primary-main "
                   href="##">
                    <div class="w-full p-4 backdrop-blur-sm">
                        <div class="text-start text-xl">Встреча с вице-министром науки и высшего образования Республики
                            Казахстан
                        </div>
                    </div>
                </a>
            </div>
            <div
                class="text-center flex flex-col h-48 justify-center items-center border rounded-md overflow-hidden relative">
                <a class="flex items-center w-full h-full bg-white text-gray-800 transition-colors duration-300 hover:bg-primary-main hover:text-white border-primary-main "
                   href="##">
                    <div class="w-full p-4 backdrop-blur-sm">
                        <div class="text-start text-xl">Встреча с вице-министром науки и высшего образования Республики
                            Казахстан
                        </div>
                    </div>
                </a>
            </div>
            <div
                class="text-center flex flex-col h-48 justify-center items-center border rounded-md overflow-hidden relative">
                <a class="flex items-center w-full h-full bg-white text-gray-800 transition-colors duration-300 hover:bg-primary-main hover:text-white border-primary-main "
                   href="##">
                    <div class="w-full p-4 backdrop-blur-sm">
                        <div class="text-start text-xl">Встреча с вице-министром науки и высшего образования Республики
                            Казахстан
                        </div>
                    </div>
                </a>
            </div>
            <div
                class="text-center flex flex-col h-48 justify-center items-center border rounded-md overflow-hidden relative">
                <a class="flex items-center w-full h-full bg-white text-gray-800 transition-colors duration-300 hover:bg-primary-main hover:text-white border-primary-main "
                   href="##">
                    <div class="w-full p-4 backdrop-blur-sm">
                        <div class="text-start text-xl">Встреча с вице-министром науки и высшего образования Республики
                            Казахстан
                        </div>
                    </div>
                </a>
            </div>
        </div>
    </div>
    <div class="mt-20">
        @include('custom-components.home-heading', ['title' => __('home.academyNews'), 'link' => '##'])
        <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-3 gap-6 mt-8">
            @foreach($news as $item)
                <div
                    class="bg-white text-center flex flex-col h-64 justify-center items-center rounded-md border overflow-hidden relative">
                    <a class="block w-full h-full" href="{{ route('news.show', $item->getProperty('slug')) }}">
                        <img class="w-full h-full object-cover transition duration-300 ease-in-out hover:scale-110"
                             src="{{ $item->preview_ru }}" alt="{{ $item->getProperty('title')  }}">
                        <div
                            class="absolute bottom-0 left-0 bg-primary-main bg-opacity-75 w-full h-28 p-4 backdrop-blur-sm">
                            <div
                                class="text-start text-md text-gray-100 border-b border-b-primary-main h-14">{{ $item->getProperty('title')  }}</div>
                            <div class="text-start text-md text-primary-light text-sm mt-2">
                                <span><i class="fal fa-calendar"></i> 12.07.2024</span>
                                <span class="ml-4"><i class="fal fa-eye"></i> {{ $item->getProperty('views')  }}</span>
                                @if($item->isLikedBy(Auth::id()))
                                    <span class="ml-2"><i class="fas text-red-500 fa-heart"></i> {{ $item->likes->count()  }}</span>
                                @else
                                    <span class="ml-2"><i class="fal fa-heart"></i> {{ $item->likes->count()  }}</span>
                                @endif
                                <span class="ml-4"><i class="fal fa-comment"></i> {{ $item->comments->count() }}</span>
                            </div>
                        </div>
                    </a>
                </div>
            @endforeach
        </div>
    </div>
@endsection

@push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>
    <script src="/assets/js/plugins/slider.js"></script>
    <script src="/assets/js/plugins/counter.js"></script>
@endpush
