@extends('layouts.public', ['kzLink' => 'faculties/', 'ruLink' => 'faculties/', 'enLink' => 'faculties/'])

@section('content')
    <div class="container mx-auto px-4">
        <div class="mt-[40px]">
            <x-breadcrumbs :items="[
                ['title' => __('public.pageHome'), 'url' => route('home')],
                ['title' => __('public.faculties')],
            ]"/>
        </div>

        <div class="mt-[40px] pb-[50px] xl:pb-[100px]">
            <div class="">
                <div class="bg-white p-[20px] rounded-[15px] shadow-md">
                    <div class="flex">
                        <div class="flex-1">
                            {{--                        <div>tabs</div>--}}
                            <div>
                                <h1 class="text-[44px] font-bold">{{ __('public.faculties') }}</h1>
                            </div>
                            <div class="mt-[60px]">
                                @foreach($faculties as $parent)
                                    <div>
                                        <a href="{{ route('faculties.show', $parent->getProperty('slug')) }}"
                                           class="text-sm md:text-lg xl:text-xl block mb-[16px] px-[24px] py-[10px] font-semibold text-[var(--color-main)] hover:text-white bg-white hover:bg-[var(--color-main)] border border-[var(--color-main)] rounded-[10px] transition-all duration-300">{{ $parent->getProperty('name') }}</a>
                                        @if($parent->children->isNotEmpty())
                                            <ul class="pl-[20px] xl:pl-[40px]">
                                                @foreach($parent->children as $child)
                                                    <li class="">
                                                        <a href="{{ route('faculties.show', $child->getProperty('slug')) }}"
                                                           class="text-sm md:text-lg xl:text-xl block border border-[var(--color-main)] py-[5px] px-[15px] mb-[16px] rounded-[10px] text-[var(--color-main)] hover:text-white bg-white hover:bg-[var(--color-main)] transition-all duration-300">{{ $child->getProperty('name') }}</a>
                                                    </li>
                                                @endforeach
                                            </ul>
                                        @endif
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
