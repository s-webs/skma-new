<div class="border-b pb-[20px]">
    <x-page-title>{{ $item->getProperty('name') }}</x-page-title>
</div>

@if($item->preview)
    <div class="mt-[60px] mb-[60px]">
        <img src="/{{ $item->preview }}" alt="{{ $item->getProperty('name') }}"
             class="w-full lg:w-[70%] rounded-[15px] mx-auto">
    </div>
@endif

<div class="mt-[30px] content">
    {!! $item->getProperty('description') !!}
</div>

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
