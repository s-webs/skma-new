<div class="directory">
    @foreach($directory as $item)
        <h3 class="font-semibold text-2xl mb-[30px] bg-[var(--color-halftone)] rounded-[10px] px-[20px] py-[10px] text-[var(--color-main)]">{{ $item['directory_name'] }}</h3>
        @foreach($item['subdirectories'] as $dir)
            <div x-data="{ open: false }" class="mb-[30px] w-full px-[20px]">
                <h4 class="font-semibold text-xl border-b flex justify-between items-center cursor-pointer"
                    @click="open = !open">
                    <span>{{ $dir['directory_name'] }}</span>
                    <i :class="open ? 'fas fa-chevron-up' : 'fas fa-chevron-down'"></i>
                </h4>
                <ul x-show="open" class="mt-[15px]" x-transition>
                    @foreach($dir['files'] as $file)
                        <li class="my-[15px]">
                            <a href="/uploads/{{ $file['path'] }}" class="text-[var(--color-heading)] hover:text-[var(--color-main)] transition-all duration-300 break-all" target="_blank">
                                <i class="far fa-file-pdf mr-1 text-[var(--color-main)]"></i>
                                <span class="underline">{{ $file['filename'] }}</span>
                            </a>
                        </li>
                    @endforeach
                </ul>
            </div>
        @endforeach
    @endforeach
</div>
