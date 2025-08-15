<style>
    body {
        font-family: DejaVu Sans, sans-serif;
        font-size: 12px;
        line-height: 1.5;
    }
</style>

<h1>{{ $title }}</h1>

{!! $description !!}

@if (!empty($contacts))
    <h3>@lang('Контакты')</h3>
    <ul>
        @foreach ($contacts as $contact)
            <li><strong>{{ $contact['key'] ?? '' }}</strong> {{ $contact['value'] ?? '' }}</li>
        @endforeach
    </ul>
@endif
