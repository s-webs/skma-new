@if($item->staff)
    <div class="flex flex-wrap justify-between mt-[30px]">
        @foreach($item->staff as $member)
            <div
                class="border border-[var(--color-main)] w-full md:w-[48%] mb-[20px] p-[20px] rounded-[15px]">
                <div class="">
                    @if($member['photo'])
                        <img src="/{{ $member['photo'] }}" alt="{{ $member['name'] }}"
                             class="w-[120px] h-[120px] rounded-full object-cover">
                    @else
                        <img src="/assets/images/no_photo.png" alt="{{ $member['name'] }}"
                             class="w-[120px] h-[120px] rounded-full object-cover">
                    @endif
                </div>
                <div class="font-semibold mt-[24px]">{{ $member['name'] }}</div>
                <div>{{ $member['position'] }}</div>
            </div>
        @endforeach
    </div>
@endif
