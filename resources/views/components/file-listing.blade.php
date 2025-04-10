<div class="directory">
    @foreach($directory as $item)
        <ul class="mt-[15px]">
            @foreach($item['files'] as $file)
                <li class="my-[10px]">
                    <a href="/uploads/{{$file['path']}}" class="flex justify-between items-center text-[var(--color-heading)] px-[30px] py-[15px] border border-[var(--color-main)] hover:bg-[var(--color-main)] hover:text-white transition-all duration-300 rounded-[10px]" target="_blank">
                        <span class="">{{ $file['filename'] }}</span>
                        <i class="far fa-file-pdf text-2xl"></i>
                    </a>
                </li>
            @endforeach
        </ul>
    @endforeach
</div>
