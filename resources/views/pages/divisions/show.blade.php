@extends('layouts.public', ['kzLink' => 'structure/' . $item->slug_kz, 'ruLink' => 'structure/' . $item->slug_ru, 'enLink' => 'structure/' . $item->slug_en])

@section('content')
    <div class="container mx-auto">
        <div class="mt-[40px]">
            <x-breadcrumbs :items="[
                ['title' => __('public.pageHome'), 'url' => route('home')],
                ['title' => __('public.structure'), 'url' => route('structure.index')],
                ['title' => $item->getProperty('name')],
            ]"/>
        </div>
    </div>
    <div class="mt-[40px] pb-[50px] xl:pb-[100px]">
        <div class="px-[120px]">
            <div class="bg-white p-[20px]">
                <div class="flex flex-1 mr-[40px]">
                    <div>
                        {{--                        <div>tabs</div>--}}
                        <div>
                            <h1 class="text-[44px] font-bold">{{ $item->getProperty('name') }}</h1>
                        </div>
                        <div class="mt-[30px]">
                            {!! $item->getProperty('description') !!}
                        </div>
                        @if($item->getProperty('documents'))
                            <div class="mt-[40px]">
                                @foreach(json_decode($item->getProperty('documents')) as $document)
                                    <div class="mb-[40px]">
                                        <a href="/{{ $document->path }}" target="_blank"
                                           class="px-[15px] py-[10px] border border-custom-main rounded-full hover:bg-custom-main hover:text-white font-semibold transition-all duration-300">
                                            @if($document->extension === 'pdf')
                                                <i class="fal fa-file-pdf"></i>
                                            @elseif($document->extension === 'doc' || $document->extension === 'docx')
                                                <i class="fal fa-file-word"></i>
                                            @else
                                                <i class="fal fa-file"></i>
                                            @endif
                                            <span class="ml-[10px]">{{ $document->original_name }}</span>
                                        </a>
                                    </div>
                                @endforeach
                            </div>
                        @endif
                    </div>
                    <div class="w-[625px] p-[20px] flex-shrink-0 border-l px-[20px]">
                        <div>
                            @if($item->parent)
                                <div>
                                    <a href="{{ route('structure.show', $item->parent->getProperty('slug')) }}"
                                       class="font-semibold">
                                        {{ $item->parent->getProperty('name') }}
                                    </a>
                                </div>
                                <div class="pl-[20px]">
                                    @foreach($item->parent->children as $child)
                                        <div>
                                            @if($child->id === $item->id)
                                                <span
                                                    class="text-custom-main font-semibold">{{ $item->getProperty('name') }}
                                                </span>
                                            @else
                                                <a href="{{ route('structure.show', $child->getProperty('slug')) }}"
                                                    class="">{{ $child->getProperty('name') }}
                                                </a>
                                            @endif
                                        </div>
                                    @endforeach
                                    @if($item->children)
                                        <div class="pl-[20px]">
                                            @foreach($item->children as $child)
                                                <div>
                                                    <a href="{{ route('structure.show', $child->getProperty('slug')) }}"
                                                       class="">{{ $child->getProperty('name') }}</a>
                                                </div>
                                            @endforeach
                                        </div>
                                    @endif
                                </div>
                            @else
                                <div class="">
                                    <div>
                                        <span
                                            class="text-custom-main font-semibold">{{ $item->getProperty('name') }}</span>
                                    </div>
                                    @if($item->children)
                                        <div class="pl-[20px]">
                                            @foreach($item->children as $child)
                                                <div>
                                                    <a href="{{ route('structure.show', $child->getProperty('slug')) }}"
                                                       class="">{{ $child->getProperty('name') }}</a>
                                                </div>
                                            @endforeach
                                        </div>
                                    @endif
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
