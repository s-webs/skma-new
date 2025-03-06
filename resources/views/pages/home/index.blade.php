@extends('layouts.public', ['kzLink' => null, 'ruLink' => null, 'enLink' => null])

@push('styles')

@endpush

@section('content')
    @include('pages.home.components.announce', compact('announcements'))
    @include('pages.home.components.mobileAnnounce', compact('announcements'))
    @include('pages.home.components.counters', compact('counters'))
    @include('pages.home.components.newsComponent', compact('news', 'latestArticle'))
    @include('pages.home.components.feedback', compact('feedbacks'))
    @include('pages.home.components.ads', compact('adverts'))
    @include('pages.home.components.services', compact('services'))
    @include('pages.home.components.gallery', compact('gallery'))
    @include('pages.home.components.awards', compact('awards'))
@endsection

@push('scripts')

@endpush
