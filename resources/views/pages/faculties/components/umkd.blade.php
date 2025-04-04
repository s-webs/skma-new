@if($item->umkd)
    <div class="pt-[30px]">
        @foreach($item->umkd as $umkd)
            <div>
                <div>
                    <h3 class="text-xl font-semibold">{{ $umkd['type'] }}</h3>
                </div>
                <div class="mt-[10px]">
                    @foreach($umkd['files'] as $umkd_item)
                        <div class="">
                            <a href="/{{ $umkd_item['path'] }}" class="hover:text-[var(--color-main)] font-semibold text-md transition-all duration-300 underline" target="_blank">
                                <i class="fa fa-file"></i>
                                <span>{{ $umkd_item['filename'] }}</span>
                            </a>
                        </div>
                    @endforeach
                </div>
            </div>
        @endforeach
    </div>
@endif
