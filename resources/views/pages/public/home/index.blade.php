@extends('layouts.public')

@push('styles')
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css"/>
@endpush

@section('content')
    <div class="swiper swiper-top mySwiper rounded-md">
        <div class="swiper-wrapper">
            <div class="swiper-slide swiper-slide-top relative">
                <img class="w-full h-full object-cover" src="/assets/images/test/test-01.jpg" alt="">
                <div
                    class="w-full h-full absolute inset-0 bg-gradient-to-tr from-indigo-900 to-blue-800 z-10 opacity-40"></div>
                <div
                    class="absolute bottom-20 left-20 text-start z-20 bg-white bg-opacity-70 p-8 rounded-md backdrop-blur-sm">
                    <div class="text-4xl">Встреча с представителем АО "Финансовый центр"</div>
                    <div class="mt-4" style="width: 800px;">Согласно решению заседания Правительства Республики
                        Казахстан 2021-2022 учебный год для обучающихся колледжей и вузов всех направлений подготовки
                        кадров будет проходить в традиционном формате...
                    </div>
                    <div class="mt-4">
                        <a class="bg-primary-main hover:bg-primary-secondary duration-300 text-white px-6 py-2 rounded-md"
                           href="##">Подробнее</a>
                    </div>
                </div>
            </div>
            <div class="swiper-slide swiper-slide-top relative">
                <img class="w-full h-full object-cover" src="/assets/images/test/test-02.jpg" alt="">
                <div
                    class="w-full h-full absolute inset-0 bg-gradient-to-tr from-indigo-900 to-blue-800 z-10 opacity-40"></div>
                <div
                    class="absolute bottom-20 left-20 text-start z-20 bg-white bg-opacity-70 p-8 rounded-md backdrop-blur-sm">
                    <div class="text-4xl">Встреча с представителем АО "Финансовый центр"</div>
                    <div class="mt-4" style="width: 800px;">Согласно решению заседания Правительства Республики
                        Казахстан 2021-2022 учебный год для обучающихся колледжей и вузов всех направлений подготовки
                        кадров будет проходить в традиционном формате...
                    </div>
                    <div class="mt-4">
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
    <div class="mt-20">
        @include('custom-components.home-heading', ['title' => __('home.academyCounter')])
        <div class="grid grid-cols-1 md:grid-cols-5 gap-6 mt-8">
            @foreach($counters as $counter)
                <div class="bg-white p-4 text-center h-48 flex flex-col justify-center items-center rounded-md border">
                    <div class="text-xl">{{ $counter->getProperty('name') }}</div>
                    <div class="font-bold text-4xl counter mt-4" data-target="{{ $counter->count }}">0</div>
                </div>
            @endforeach
        </div>
    </div>
    <div class="mt-20">
        @include('custom-components.home-heading', ['title' => __('home.academyServices')])

        <div class="swiper slider-services mt-8 h-72">
            <div class="swiper-wrapper">
                <div class="swiper-slide overflow-hidden swiper-slide-services border rounded-md relative">
                    <div class="text-black absolute top-5 left-5 font-bold">3D ТУР</div>
                    <div class="bg-cyan-600 absolute w-64 h-64 rounded-full -left-8 -bottom-20 overflow-hidden">
                        <img src="/assets/images/test/test-03.png" alt="" class="w-full h-full object-cover">
                    </div>
                </div>
                <div class="swiper-slide overflow-hidden swiper-slide-services border rounded-md relative">
                    <div class="text-black absolute top-5 left-5 font-bold">3D ТУР</div>
                    <div class="bg-cyan-600 absolute w-64 h-64 rounded-full -left-8 -bottom-20 overflow-hidden">
                        <img src="/assets/images/test/test-03.png" alt="" class="w-full h-full object-cover">
                    </div>
                </div>
                <div class="swiper-slide overflow-hidden swiper-slide-services border rounded-md relative">
                    <div class="text-black absolute top-5 left-5 font-bold">3D ТУР</div>
                    <div class="bg-cyan-600 absolute w-64 h-64 rounded-full -left-8 -bottom-20 overflow-hidden">
                        <img src="/assets/images/test/test-03.png" alt="" class="w-full h-full object-cover">
                    </div>
                </div>
                <div class="swiper-slide overflow-hidden swiper-slide-services border rounded-md relative">
                    <div class="text-black absolute top-5 left-5 font-bold">3D ТУР</div>
                    <div class="bg-cyan-600 absolute w-64 h-64 rounded-full -left-8 -bottom-20 overflow-hidden">
                        <img src="/assets/images/test/test-03.png" alt="" class="w-full h-full object-cover">
                    </div>
                </div>
                <div class="swiper-slide overflow-hidden swiper-slide-services border rounded-md relative">
                    <div class="text-black absolute top-5 left-5 font-bold">3D ТУР</div>
                    <div class="bg-cyan-600 absolute w-64 h-64 rounded-full -left-8 -bottom-20 overflow-hidden">
                        <img src="/assets/images/test/test-03.png" alt="" class="w-full h-full object-cover">
                    </div>
                </div>
                <div class="swiper-slide overflow-hidden swiper-slide-services border rounded-md relative">
                    <div class="text-black absolute top-5 left-5 font-bold">3D ТУР</div>
                    <div class="bg-cyan-600 absolute w-64 h-64 rounded-full -left-8 -bottom-20 overflow-hidden">
                        <img src="/assets/images/test/test-03.png" alt="" class="w-full h-full object-cover">
                    </div>
                </div>
                <div class="swiper-slide overflow-hidden swiper-slide-services border rounded-md relative">
                    <div class="text-black absolute top-5 left-5 font-bold">3D ТУР</div>
                    <div class="bg-cyan-600 absolute w-64 h-64 rounded-full -left-8 -bottom-20 overflow-hidden">
                        <img src="/assets/images/test/test-03.png" alt="" class="w-full h-full object-cover">
                    </div>
                </div>
                <div class="swiper-slide overflow-hidden swiper-slide-services border rounded-md relative">
                    <div class="text-black absolute top-5 left-5 font-bold">3D ТУР</div>
                    <div class="bg-cyan-600 absolute w-64 h-64 rounded-full -left-8 -bottom-20 overflow-hidden">
                        <img src="/assets/images/test/test-03.png" alt="" class="w-full h-full object-cover">
                    </div>
                </div>
                <div class="swiper-slide overflow-hidden swiper-slide-services border rounded-md relative">
                    <div class="text-black absolute top-5 left-5 font-bold">3D ТУР</div>
                    <div class="bg-cyan-600 absolute w-64 h-64 rounded-full -left-8 -bottom-20 overflow-hidden">
                        <img src="/assets/images/test/test-03.png" alt="" class="w-full h-full object-cover">
                    </div>
                </div>
                <div class="swiper-slide overflow-hidden swiper-slide-services border rounded-md relative">
                    <div class="text-black absolute top-5 left-5 font-bold">3D ТУР</div>
                    <div class="bg-cyan-600 absolute w-64 h-64 rounded-full -left-8 -bottom-20 overflow-hidden">
                        <img src="/assets/images/test/test-03.png" alt="" class="w-full h-full object-cover">
                    </div>
                </div>
            </div>
            <div class="swiper-button-next swiper-next-services"></div>
            <div class="swiper-button-prev swiper-prev-services"></div>
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
        @include('custom-components.home-heading', ['title' => 'новости академии', 'link' => '##'])
        <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mt-8">
            <div
                class="bg-white text-center flex flex-col h-64 justify-center items-center rounded-md border rounded-md overflow-hidden relative">
                <a class="block w-full h-full" href="##">
                    <img class="w-full h-full object-cover" src="/assets/images/test/test-03.jpg" alt="">
                    <div class="absolute bottom-0 left-0 bg-black bg-opacity-45 w-full h-28 p-4 backdrop-blur-sm">
                        <div class="text-start text-xl text-white">Встреча с вице-министром науки и высшего образования
                            Республики Казахстан
                        </div>
                    </div>
                </a>
            </div>
            <div
                class="bg-white text-center flex flex-col h-64 justify-center items-center rounded-md border rounded-md overflow-hidden relative">
                <a class="block w-full h-full" href="##">
                    <img class="w-full h-full object-cover" src="/assets/images/test/test-03.jpg" alt="">
                    <div class="absolute bottom-0 left-0 bg-black bg-opacity-45 w-full h-28 p-4 backdrop-blur-sm">
                        <div class="text-start text-xl text-white">Встреча с вице-министром науки и высшего образования
                            Республики Казахстан
                        </div>
                    </div>
                </a>
            </div>
            <div
                class="bg-white text-center flex flex-col h-64 justify-center items-center rounded-md border rounded-md overflow-hidden relative">
                <a class="block w-full h-full" href="##">
                    <img class="w-full h-full object-cover" src="/assets/images/test/test-03.jpg" alt="">
                    <div class="absolute bottom-0 left-0 bg-black bg-opacity-45 w-full h-28 p-4 backdrop-blur-sm">
                        <div class="text-start text-xl text-white">Встреча с вице-министром науки и высшего образования
                            Республики Казахстан
                        </div>
                    </div>
                </a>
            </div>
            <div
                class="bg-white text-center flex flex-col h-64 justify-center items-center rounded-md border rounded-md overflow-hidden relative">
                <a class="block w-full h-full" href="##">
                    <img class="w-full h-full object-cover" src="/assets/images/test/test-03.jpg" alt="">
                    <div class="absolute bottom-0 left-0 bg-black bg-opacity-45 w-full h-28 p-4 backdrop-blur-sm">
                        <div class="text-start text-xl text-white">Встреча с вице-министром науки и высшего образования
                            Республики Казахстан
                        </div>
                    </div>
                </a>
            </div>
            <div
                class="bg-white text-center flex flex-col h-64 justify-center items-center rounded-md border rounded-md overflow-hidden relative">
                <a class="block w-full h-full" href="##">
                    <img class="w-full h-full object-cover" src="/assets/images/test/test-03.jpg" alt="">
                    <div class="absolute bottom-0 left-0 bg-black bg-opacity-45 w-full h-28 p-4 backdrop-blur-sm">
                        <div class="text-start text-xl text-white">Встреча с вице-министром науки и высшего образования
                            Республики Казахстан
                        </div>
                    </div>
                </a>
            </div>
            <div
                class="bg-white text-center flex flex-col h-64 justify-center items-center rounded-md border rounded-md overflow-hidden relative">
                <a class="block w-full h-full" href="##">
                    <img class="w-full h-full object-cover" src="/assets/images/test/test-03.jpg" alt="">
                    <div class="absolute bottom-0 left-0 bg-black bg-opacity-45 w-full h-28 p-4 backdrop-blur-sm">
                        <div class="text-start text-xl text-white">Встреча с вице-министром науки и высшего образования
                            Республики Казахстан
                        </div>
                    </div>
                </a>
            </div>
            <div
                class="bg-white text-center flex flex-col h-64 justify-center items-center rounded-md border rounded-md overflow-hidden relative">
                <a class="block w-full h-full" href="##">
                    <img class="w-full h-full object-cover" src="/assets/images/test/test-03.jpg" alt="">
                    <div class="absolute bottom-0 left-0 bg-black bg-opacity-45 w-full h-28 p-4 backdrop-blur-sm">
                        <div class="text-start text-xl text-white">Встреча с вице-министром науки и высшего образования
                            Республики Казахстан
                        </div>
                    </div>
                </a>
            </div>
            <div
                class="bg-white text-center flex flex-col h-64 justify-center items-center rounded-md border rounded-md overflow-hidden relative">
                <a class="block w-full h-full" href="##">
                    <img class="w-full h-full object-cover" src="/assets/images/test/test-03.jpg" alt="">
                    <div class="absolute bottom-0 left-0 bg-black bg-opacity-45 w-full h-28 p-4 backdrop-blur-sm">
                        <div class="text-start text-xl text-white">Встреча с вице-министром науки и высшего образования
                            Республики Казахстан
                        </div>
                    </div>
                </a>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>
    <script src="/assets/js/plugins/slider.js"></script>
    <script src="/assets/js/plugins/counter.js"></script>
@endpush
