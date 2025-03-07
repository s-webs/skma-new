@extends('layouts.public', ['kzLink' => 'structure/', 'ruLink' => 'structure/', 'enLink' => 'structure/'])

@section('content')
    <div class="container mx-auto">
        <div class="mt-[40px]">
            <x-breadcrumbs :items="[
                ['title' => __('public.pageHome'), 'url' => route('home')],
                ['title' => __('public.structure')],
            ]"/>
        </div>
    </div>
    <div class="mt-[40px] pb-[50px] xl:pb-[100px]">
        <div class="px-[120px]">
            <div class="bg-white p-[20px] rounded-[15px] shadow-md">
                <div class="flex mr-[40px]">
                    <div class="flex-1">
                        {{--                        <div>tabs</div>--}}
                        <div>
                            <h1 class="text-[44px] font-bold">{{ __('public.structure') }}</h1>
                        </div>
                        <div class="mt-[60px]">
                            @foreach($divisions as $parent)
                                <div>
                                    <a href="{{ route('structure.show', $parent->getProperty('slug')) }}" class="block mb-[16px] px-[24px] py-[10px] font-semibold text-custom-main hover:text-white bg-white hover:bg-custom-main border border-custom-main rounded-full transition-all duration-300">{{ $parent->getProperty('name') }}</a>
                                    @if($parent->children->isNotEmpty())
                                        <ul class="pl-[40px]">
                                            @foreach($parent->children as $child)
                                                <li class="">
                                                    <a href="{{ route('structure.show', $child->getProperty('slug')) }}" class="block border border-custom-main py-[5px] px-[15px] mb-[16px] rounded-full text-custom-main hover:text-white bg-white hover:bg-custom-main transition-all duration-300">{{ $child->getProperty('name') }}</a>
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
@endsection
