@extends('layouts.public', ['kzLink' => 'dis-sovet/programs/' . $program->id . '/announcement', 'ruLink' => 'dis-sovet/programs/' . $program->id . '/announcement', 'enLink' => 'dis-sovet/programs/' . $program->id . '/announcement'])

@section('content')
    <div class="container mx-auto px-4 mb-[60px]">
        <div class="mt-[40px] md:mt-[60px] xl:mt-[40px]">
            <x-breadcrumbs :items="[
                ['title' => __('public.pageHome'), 'url' => route('home')],
                ['title' => __('dissovet.dissertation_council'), 'url' => route('dissovet.index')],
                ['title' => __('dissovet.edu_programs'), 'url' => route('dissovet.programs')],
                ['title' => __('dissovet.announcements_about_dissertation_defenses') . ' (' . $program->getProperty('name') . ')', 'url' => route('dissovet.announcement', $program->id)],
            ]"/>
        </div>
        <div class="mt-[60px] pb-[50px] py-[20px] xl:pb-[100px] bg-white shadow-md rounded-[15px] px-4 2xl:px-28">
            <div>
                <x-page-title>{{ __('dissovet.announcements_about_dissertation_defenses') }}
                    ({{ $program->getProperty('name') }})
                </x-page-title>
            </div>
            <div class="mt-[70px]">
                @foreach($program->announcements as $item)
                    <div x-data="{ open: false }" class="mb-6">
                        <!-- Заголовок с кнопкой -->
                        <button
                            @click="open = !open"
                            class="w-full bg-[var(--color-halftone)] p-[24px] rounded-[20px] flex items-center justify-between"
                        >
                            <span class="font-semibold text-left">{{ $item->getProperty('name') }}</span>
                            <i :class="open ? 'fal fa-minus' : 'fal fa-plus'" class="text-2xl transition-all duration-300"></i>
                        </button>

                        <!-- Контент -->
                        <div
                            x-show="open"
                            x-transition
                            class="overflow-hidden border border-[var(--color-main)] mt-2 rounded-[15px]"
                        >
                            <div class="p-[18px]">{!! $item->getProperty('description') !!}</div>

                            <div class="mt-[30px] px-[16px] pb-[16px]">
                                @foreach($item->files as $file)
                                    <div class="mb-[10px]">
                                        <a href="/{{ $file['path'] }}" target="_blank"
                                           class="p-[20px] bg-[var(--color-halftone)] rounded-[30px] flex items-center group hover:bg-[var(--color-main)] transition-all duration-300">
                                            <div
                                                class="bg-[var(--color-main)] w-[18px] h-[18px] rounded-full mr-[8px] group-hover:bg-white transition-all duration-300"></div>
                                            <span
                                                class="font-semibold group-hover:text-white transition-all duration-300">{{ $file['name'] }}</span>
                                        </a>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                @endforeach

            </div>
        </div>
    </div>
@endsection
