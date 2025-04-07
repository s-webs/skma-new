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

        <div class="mt-[40px] mb-[60px] pb-[50px] xl:pb-[100px] bg-white pt-[30px] px-[40px] rounded-[15px] shadow-md">
            <div class="file-manager-container">
                <iframe
                    src="{{ route('fmanager.index', ['root' => '/uploads']) }}"
                    style="width: 100%; height: 800px; border: 1px solid #ccc;"
                ></iframe>
                <input type="hidden" name="file_path" id="selected-file">
            </div>
            <div>
                <x-page-title>{{ __('public.visits') }}</x-page-title>
            </div>
            <div class="mt-[60px]">
                @foreach(['today' => 'Today', 'week' => 'Week', 'month' => 'Month', 'year' => 'Year'] as $period => $title)
                    <div class="mb-[40px]">
                        <x-inner-heading>{{ $title }}</x-inner-heading>
                        <table>
                            <thead>
                            <tr>
                                <th>Flag</th>
                                <th>Country</th>
                                <th>Count</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($statistics[$period] as $country)
                                <tr>
                                    <td><img src="{{ $country['flag'] }}" alt="{{ $country['name'] }} flag"></td>
                                    <td>{{ $country['name'] }}</td>
                                    <td>{{ $country['count'] }}</td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
@endsection

@push('styles')
    <style>
        table {
            border-collapse: collapse;
            width: 100%;
        }

        th,
        td {
            border: 1px solid black;
            padding: 8px;
            text-align: left;
        }

        th {
            background-color: #f2f2f2;
        }
    </style>
@endpush
