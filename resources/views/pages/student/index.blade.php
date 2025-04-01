@extends('layouts.public', ['kzLink' => 'for-the-student/', 'ruLink' => 'for-the-student/', 'enLink' => 'for-the-student/'])

@section('content')
    <div class="w-full py-[60px] h-auto xl:h-[600px] 2xl:h-[700px] overflow-hidden relative">
        <div class="w-full h-full absolute top-0 left-0 bg-[var(--color-main)]">
            <img src="/assets/images/for-students.jpg" alt="/assets/images/for-students.jpg"
                 class="w-full h-full object-cover absolute top-0 left-0 z-[2]">
            <div class="w-full h-full bg-[var(--color-main)] opacity-40 absolute top-0 left-0 z-[2]"></div>
        </div>
        <div class="relative flex justify-center items-center h-full">
            <div class="container mx-auto px-4">
                <div class="relative w-full z-[3]">
                    <div class="text-white text-xl md:text-[36px] font-bold">
                        <h1>{{ $information->getProperty('title') }}</h1>
                    </div>
                    <div class="text-md md:text-[18px] text-white mt-[20px] max-w-[500px]">
                        {{ $information->getProperty('description') }}
                    </div>
                    <div class="flex flex-wrap xl:flex-nowrap items-center w-full mt-[40px]">
                        @foreach(json_decode($information->getProperty('cards')) as $item)
                            @if($item->title !== null)
                                <x-link-card url="/{{ $item->file }}"
                                             title="{{ $item->subtitle }}"
                                             subtitle="{{ $item->title }}"/>
                            @endif
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div>
        @include('pages.home.components.services', compact('services'))
    </div>
    <div class="container mx-auto px-4 py-[50px] xl:py-[100px]">
        <div class="">
            <div class="flex flex-wrap">
                <div class="flex-1 md:mr-[30px]">
                    <div class="text-[24px] md:text-[36px] font-bold">
                        <h3>Расписание занятий</h3>
                    </div>
                    <div class="mt-[30px]">
                        @foreach($scheduleLessons as $item)
                            <div class="my-[15px]">
                                <div>
                                    <x-info-card title="{{ $item['title'] }}" link="{{ $item['link'] }}" />
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
                <div class="flex-1">
                    <div class="text-[24px] md:text-[36px] font-bold">
                        <h3>Расписание экзаменов</h3>
                    </div>
                    <div class="mt-[30px]">
                        @foreach($scheduleExam as $item)
                            <div class="my-[15px]">
                                <div>
                                    <x-info-card title="{{ $item['title'] }}" link="{{ $item['link'] }}" />
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
