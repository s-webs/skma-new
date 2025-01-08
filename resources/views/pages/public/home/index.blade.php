@extends('layouts.public')

@push('styles')
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css" />
    <style>
        .swiper-top {
            width: 100%;
            height: 640px
        }

        .swiper-slide-top {
            text-align: center;
            font-size: 18px;
            background: #fff;
            display: flex;
            justify-content: center;
            align-items: center;
        }

        .swiper-slide-top img {
            display: block;
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .swiper-slide-services {
            text-align: center;
            font-size: 18px;
            background: #fff;
            display: flex;
            justify-content: center;
            align-items: center;
        }

        .swiper-button-next, .swiper-button-prev {
            color: #4d7edc;
        }
        .swiper-pagination-fraction {
            color: #fff;
        }
    </style>
@endpush

@section('content')
    <div class="swiper swiper-top mySwiper rounded-md">
        <div class="swiper-wrapper">
            <div class="swiper-slide swiper-slide-top relative">
                <img class="w-full h-full object-cover" src="/assets/images/test/test-01.jpg" alt="">
                <div class="w-full h-full absolute inset-0 bg-gradient-to-tr from-indigo-900 to-blue-800 z-10 opacity-40"></div>
                <div class="absolute bottom-20 left-20 text-start z-20 bg-white bg-opacity-70 p-8 rounded-md backdrop-blur-sm">
                    <div class="text-4xl">Встреча с представителем АО "Финансовый центр"</div>
                    <div class="mt-4" style="width: 800px;">Согласно решению заседания Правительства Республики Казахстан 2021-2022 учебный год для обучающихся колледжей и вузов всех направлений подготовки кадров будет проходить в традиционном формате...</div>
                    <div class="mt-4">
                        <a class="bg-primary-main hover:bg-primary-secondary duration-300 text-white px-6 py-2 rounded-md" href="##">Подробнее</a>
                    </div>
                </div>
            </div>
            <div class="swiper-slide swiper-slide-top relative">
                <img class="w-full h-full object-cover" src="/assets/images/test/test-02.jpg" alt="">
                <div class="w-full h-full absolute inset-0 bg-gradient-to-tr from-indigo-900 to-blue-800 z-10 opacity-40"></div>
                <div class="absolute bottom-20 left-20 text-start z-20 bg-white bg-opacity-70 p-8 rounded-md backdrop-blur-sm">
                    <div class="text-4xl">Встреча с представителем АО "Финансовый центр"</div>
                    <div class="mt-4" style="width: 800px;">Согласно решению заседания Правительства Республики Казахстан 2021-2022 учебный год для обучающихся колледжей и вузов всех направлений подготовки кадров будет проходить в традиционном формате...</div>
                    <div class="mt-4">
                        <a class="bg-primary-main hover:bg-primary-secondary duration-300 text-white px-6 py-2 rounded-md" href="##">Подробнее</a>
                    </div>
                </div>
            </div>
        </div>
        <div class="swiper-button-next swiper-next-top"></div>
        <div class="swiper-button-prev swiper-prev-top"></div>
        <div class="swiper-pagination"></div>
    </div>
    <div class="mt-8">
        <div class="text-2xl text-center font-bold">
            <h2>ЮКМА в цифрах</h2>
        </div>
        <div class="grid grid-cols-1 md:grid-cols-5 gap-6 mt-8">
            <div class="bg-white p-4 text-center h-48 flex flex-col justify-center items-center rounded-md border">
                <div class="text-2xl">Обучающихся</div>
                <div class="font-bold text-4xl counter mt-4" data-target="7900">0</div>
            </div>
            <div class="bg-white p-4 text-center h-48 flex flex-col justify-center items-center rounded-md border">
                <div class="text-2xl">Обучаем уже лет</div>
                <div class="font-bold text-4xl counter mt-4" data-target="46">0</div>
            </div>
            <div class="bg-white p-4 text-center h-48 flex flex-col justify-center items-center rounded-md border">
                <div class="text-2xl">Выпускников</div>
                <div class="font-bold text-4xl counter mt-4" data-target="43560">0</div>
            </div>
            <div class="bg-white p-4 text-center h-48 flex flex-col justify-center items-center rounded-md border">
                <div class="text-2xl">Кафедры</div>
                <div class="font-bold text-4xl counter mt-4" data-target="34">0</div>
            </div>
            <div class="bg-white p-4 text-center h-48 flex flex-col justify-center items-center rounded-md border">
                <div class="text-2xl">Языков обучения</div>
                <div class="font-bold text-4xl counter mt-4" data-target="3">0</div>
            </div>
            <div class="bg-white p-4 text-center h-48 flex flex-col justify-center items-center rounded-md border">
                <div class="text-2xl">Мест в общежитии</div>
                <div class="font-bold text-4xl counter mt-4" data-target="3000">0</div>
            </div>
            <div class="bg-white p-4 text-center h-48 flex flex-col justify-center items-center rounded-md border">
                <div class="text-2xl">Мест на военной кафедре</div>
                <div class="font-bold text-4xl counter mt-4" data-target="200">0</div>
            </div>
            <div class="bg-white p-4 text-center h-48 flex flex-col justify-center items-center rounded-md border">
                <div class="text-2xl">Спортивных секций</div>
                <div class="font-bold text-4xl counter mt-4" data-target="12">0</div>
            </div>
        </div>
    </div>
    <div class="mt-8">
        <div class="text-2xl text-center font-bold">
            <h2>Сервисы академии</h2>
        </div>

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
                </div><div class="swiper-slide overflow-hidden swiper-slide-services border rounded-md relative">
                    <div class="text-black absolute top-5 left-5 font-bold">3D ТУР</div>
                    <div class="bg-cyan-600 absolute w-64 h-64 rounded-full -left-8 -bottom-20 overflow-hidden">
                        <img src="/assets/images/test/test-03.png" alt="" class="w-full h-full object-cover">
                    </div>
                </div><div class="swiper-slide overflow-hidden swiper-slide-services border rounded-md relative">
                    <div class="text-black absolute top-5 left-5 font-bold">3D ТУР</div>
                    <div class="bg-cyan-600 absolute w-64 h-64 rounded-full -left-8 -bottom-20 overflow-hidden">
                        <img src="/assets/images/test/test-03.png" alt="" class="w-full h-full object-cover">
                    </div>
                </div><div class="swiper-slide overflow-hidden swiper-slide-services border rounded-md relative">
                    <div class="text-black absolute top-5 left-5 font-bold">3D ТУР</div>
                    <div class="bg-cyan-600 absolute w-64 h-64 rounded-full -left-8 -bottom-20 overflow-hidden">
                        <img src="/assets/images/test/test-03.png" alt="" class="w-full h-full object-cover">
                    </div>
                </div><div class="swiper-slide overflow-hidden swiper-slide-services border rounded-md relative">
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
    <div class="mt-8">
        <div class="text-2xl text-center font-bold">
            <h2>Объявления академии</h2>
        </div>
        <div class="">
            <div>

            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>

    <!-- Initialize Swiper -->
    <script>
        var swiper = new Swiper(".mySwiper", {
            autoplay: {
                delay: 5000,
            },
            pagination: {
                el: ".swiper-pagination",
                type: "fraction",
            },
            navigation: {
                nextEl: ".swiper-next-top",
                prevEl: ".swiper-prev-top",
            },
        });

        var swiper = new Swiper(".slider-services", {
            autoplay: {
                delay: 3000,
            },
            slidesPerView: 5,
            spaceBetween: 30,
            navigation: {
                nextEl: ".swiper-next-services",
                prevEl: ".swiper-prev-services",
            },
        });

        document.querySelectorAll('.counter').forEach(counter => {
            const target = +counter.getAttribute('data-target');
            let count = 0;
            const increment = target / 100; // Скорость анимации

            const updateCounter = () => {
                count += increment;
                if (count < target) {
                    counter.textContent = Math.floor(count);
                    requestAnimationFrame(updateCounter);
                } else {
                    counter.textContent = target;
                }
            };

            updateCounter();
        });

    </script>
@endpush
