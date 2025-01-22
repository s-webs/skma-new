<li>
    <a href="#">{{ $item->name_ru }}</a>
    @if ($item->children->count())
        <ul>
            @foreach ($item->children as $child)
                @include('pages.about.partials._item', ['item' => $child])
            @endforeach
        </ul>
    @endif
</li>
