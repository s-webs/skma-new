@extends('layouts.summerLayout', ['kzLink' => 'search/', 'ruLink' => 'search/', 'enLink' => 'search/'])

@section('content')
    <div>
        <div class="container mx-auto px-4 2xl:px-28 bg-white py-[40px] my-[40px] rounded-[15px] shadow-md">
            <div class="">
                <x-breadcrumbs :items="[
                ['title' => __('public.pageHome'), 'url' => route('home')],
                ['title' => __('public.search')],
            ]"/>
            </div>
            <div class="md:mt-[20px] border-t py-[10px] xl:py-[30px]">
                <x-page-title>{{ __('public.search') }}: {{ $query }}</x-page-title>
            </div>
            <x-search-results-block title="{{ __('public.departments_and_faculties') }}" :results="$departmentsResults" route="faculties.show" field="name"/>
            <x-search-results-block title="{{ __('public.structure') }}" :results="$divisionsResults" route="structure.show" field="name"/>
            <x-search-results-block title="{{ __('public.ads') }}" :results="$advertResults" route="ads.show" field="name"/>
            <x-search-results-block title="{{ __('public.news') }}" :results="$newsResults" route="news.show" field="title"/>
        </div>
    </div>
@endsection
