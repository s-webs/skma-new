@extends('layouts.winterLayout', ['kzLink' => 'faculties/' . $item->slug_kz, 'ruLink' => 'faculties/' . $item->slug_ru, 'enLink' => 'faculties/' . $item->slug_en])

@section('content')
    <div class="container mx-auto px-2">
        <div class="mt-[40px] md:mt-[60px] xl:mt-[40px]">
            <x-breadcrumbs :items="[
                ['title' => __('public.pageHome'), 'url' => route('home')],
                ['title' => __('public.faculties'), 'url' => route('faculties.index')],
                ['title' => $item->getProperty('name')],
            ]"/>
        </div>
        <div class="lg:hidden mt-[60px] rounded-[15px] overflow-hidden shadow-md">
            <div>
                <div id="toggleStructureMenu" class="bg-winter-main px-[25px] py-[15px]">
                    <div class="flex items-center justify-between text-white font-semibold">
                        <span class="">{{ __('public.menu') }}</span>
                        <i id="structureMenuIcon" class="fal fa-angle-right transition-all duration-300"></i>
                    </div>
                </div>
                <div id="structureMenu" class="bg-white px-[25px] py-[15px]">
                    @if($item->parent)
                        <div>
                            <a href="{{ route('faculties.show', $item->parent->getProperty('slug')) }}"
                               class="font-semibold">
                                {{ $item->parent->getProperty('name') }}
                            </a>
                        </div>
                        <div class="pl-[20px]">
                            @foreach($item->parent->children as $child)
                                <div>
                                    @if($child->id === $item->id)
                                        <span
                                            class="text-winter-main font-semibold">{{ $item->getProperty('name') }}
                                                </span>
                                    @else
                                        <a href="{{ route('faculties.show', $child->getProperty('slug')) }}"
                                           class="">{{ $child->getProperty('name') }}
                                        </a>
                                    @endif
                                </div>
                            @endforeach
                            @if($item->children)
                                <div class="pl-[20px]">
                                    @foreach($item->children as $child)
                                        <div>
                                            <a href="{{ route('faculties.show', $child->getProperty('slug')) }}"
                                               class="">{{ $child->getProperty('name') }}</a>
                                        </div>
                                    @endforeach
                                </div>
                            @endif
                        </div>
                    @else
                        <div class="">
                            <div><span class="text-winter-main font-semibold">{{ $item->getProperty('name') }}</span>
                            </div>
                            @if($item->children)
                                <div class="pl-[20px]">
                                    @foreach($item->children as $child)
                                        <div>
                                            <a href="{{ route('faculties.show', $child->getProperty('slug')) }}"
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
    <div class="mt-[40px] pb-[50px] xl:pb-[100px]">
        <div class="container mx-auto px-2 lg:max-w-full 2xl:px-[120px]">
            <div class="bg-white p-[20px] rounded-[15px] shadow-md">
                <div class="flex justify-between">
                    <div class="flex-1 mr-[0px] lg:mr-[20px] 2xl:mr-[40px]">
                        {{--                        <div>tabs</div>--}}
                        <div class="border-b pb-[20px]">
                            <x-page-title>{{ $item->getProperty('name') }}</x-page-title>
                        </div>
                        @if($item->preview)
                            <div class="mt-[60px] mb-[60px]">
                                <img src="/{{ $item->preview }}" alt="{{ $item->getProperty('name') }}"
                                     class="w-full lg:w-[70%] rounded-[15px] mx-auto">
                            </div>
                        @endif
                        <div class="mt-[30px]">
                            {!! $item->getProperty('description') !!}
                        </div>

                        @if(!empty(json_decode($item->getProperty('staff'))))
                            <div class="mt-[60px]">
                                <div>
                                    <x-inner-heading>{{ __('public.staff') }}</x-inner-heading>
                                </div>
                                <div class="flex flex-wrap justify-between mt-[30px]">
                                    @foreach(json_decode($item->getProperty('staff')) as $member)
                                        <div
                                            class="border border-winter-main w-full md:w-[48%] mb-[20px] p-[20px] rounded-[15px]">
                                            <div class="">
                                                <img src="/{{ $member->photo }}" alt="{{ $member->name }}"
                                                     class="w-[120px] h-[120px] rounded-full object-cover">
                                            </div>
                                            <div class="font-semibold mt-[24px]">{{ $member->name }}</div>
                                            <div>{{ $member->position }}</div>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        @endif

                        @if(!empty(json_decode($item->getProperty('documents'))))
                            <div class="mt-[60px]">
                                <div class="mb-[30px]">
                                    <x-inner-heading>{{ __('public.documents') }}</x-inner-heading>
                                </div>
                                @foreach(json_decode($item->getProperty('documents')) as $document)
                                    <div class="mb-[40px]">
                                        <a href="/{{ $document->path }}" target="_blank"
                                           class="hover:text-winter-main font-semibold text-md transition-all duration-300">
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

                        @if(!empty(json_decode($item->getProperty('contacts'))))
                            <div class="mb-[10px] mt-[60px]">
                                <x-inner-heading>{{ __('public.contacts') }}</x-inner-heading>
                            </div>

                            @foreach(json_decode($item->getProperty('contacts')) as $contact)
                                <div>
                                    <span class="font-semibold">{{ $contact->key }}</span>
                                    <span>{{ $contact->value }}</span>
                                </div>
                            @endforeach
                        @endif
                    </div>
                    <div class="hidden lg:block lg:w-[400px] 2xl:w-[625px] p-[20px] flex-shrink-0 border-l px-[20px]">
                        <div>
                            @if($item->parent)
                                <div>
                                    <a href="{{ route('faculties.show', $item->parent->getProperty('slug')) }}"
                                       class="font-semibold">
                                        {{ $item->parent->getProperty('name') }}
                                    </a>
                                </div>
                                <div class="pl-[20px]">
                                    @foreach($item->parent->children as $child)
                                        <div>
                                            @if($child->id === $item->id)
                                                <span
                                                    class="text-winter-main font-semibold">{{ $item->getProperty('name') }}
                                                </span>
                                            @else
                                                <a href="{{ route('faculties.show', $child->getProperty('slug')) }}"
                                                   class="">{{ $child->getProperty('name') }}
                                                </a>
                                            @endif
                                        </div>
                                    @endforeach
                                    @if($item->children)
                                        <div class="pl-[20px]">
                                            @foreach($item->children as $child)
                                                <div>
                                                    <a href="{{ route('faculties.show', $child->getProperty('slug')) }}"
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
                                            class="text-winter-main font-semibold">{{ $item->getProperty('name') }}</span>
                                    </div>
                                    @if($item->children)
                                        <div class="pl-[20px]">
                                            @foreach($item->children as $child)
                                                <div>
                                                    <a href="{{ route('faculties.show', $child->getProperty('slug')) }}"
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
