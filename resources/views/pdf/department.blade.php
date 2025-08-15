<style>
    body {
        font-family: DejaVu Sans, sans-serif;
        font-size: 12px;
        line-height: 1.5;
    }
</style>

{{-- Заголовок --}}
<h1>{{ $title }}</h1>

{{-- Описание (с HTML) --}}
{!! $description !!}

{{-- Сотрудники --}}
@if (!empty($staff))
    <h2>@lang('Сотрудники')</h2>
    <table>
        <thead>
        <tr>
            <th>#</th>
            <th>@lang('ФИО')</th>
            <th>@lang('Должность')</th>
            <th>Email</th>
            <th>@lang('Телефон')</th>
        </tr>
        </thead>
        <tbody>
        @foreach ($staff as $index => $person)
            <tr>
                <td>{{ $index + 1 }}</td>
                <td>{{ $person['name'] }}</td>
                <td>{{ $person['position'] }}</td>
                <td>{{ $person['email'] ?: '-' }}</td>
                <td>{{ $person['phone'] ?: '-' }}</td>
            </tr>
        @endforeach
        </tbody>
    </table>
@endif

{{-- Контакты --}}
@if (!empty($contacts))
    <h2>@lang('Контакты')</h2>
    <ul>
        @foreach ($contacts as $contact)
            <li><strong>{{ $contact['key'] ?? '' }}</strong> {{ $contact['value'] ?? '' }}</li>
        @endforeach
    </ul>
@endif
