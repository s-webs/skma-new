@extends('layouts.public', ['kzLink' => 'statistics/visits/', 'ruLink' => 'statistics/visits/', 'enLink' => 'statistics/visits/'])

@section('content')
    <div class="container mx-auto px-4">
        <div class="mt-[40px]">
            <x-breadcrumbs :items="[
                ['title' => __('public.pageHome'), 'url' => route('home')],
                ['title' => __('public.statistics'), 'url' => '/'],
                ['title' => __('public.visits')],
            ]"/>
        </div>

        <div class="mt-[40px] pb-[50px] xl:pb-[100px]">
            <div>
                <x-page-title>{{ __('public.visits') }}</x-page-title>
            </div>
            <div>

            </div>
        </div>
    </div>
@endsection
