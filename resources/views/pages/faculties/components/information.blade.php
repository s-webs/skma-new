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
                    class="border border-[var(--color-main)] w-full md:w-[48%] mb-[20px] p-[20px] rounded-[15px]">
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
