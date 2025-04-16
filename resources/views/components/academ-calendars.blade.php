<div class="directory">
    @foreach($directory as $item)
        <h3 class="font-semibold text-lg mb-[30px] bg-[var(--color-halftone)] rounded-[10px] px-[20px] py-[10px] text-[var(--color-main)]">{{ $item['directory_name'] }}</h3>
        <ul class="mt-[15px] px-[30px]">
            @foreach($item['files'] as $file)
                <li class="my-[15px]">
                    <a href="/uploads/{{ $file['path'] }}"
                       class="text-[var(--color-heading)] hover:text-[var(--color-main)] transition-all duration-300 break-all"
                       target="_blank">
                        <i class="far fa-file-pdf mr-1 text-[var(--color-main)]"></i>
                        <span class="underline">{{ $file['filename'] }}</span>
                    </a>
                </li>
            @endforeach
        </ul>
    @endforeach
</div>
