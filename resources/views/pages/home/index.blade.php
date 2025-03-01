@extends('layouts.public', ['kzLink' => null, 'ruLink' => null, 'enLink' => null])

@push('styles')

@endpush

@section('content')
    @include('pages.home.components.announce', compact('announcements'))
    @include('pages.home.components.mobileAnnounce', compact('announcements'))
    @include('pages.home.components.counters', compact('counters'))
@endsection

@push('scripts')

@endpush
