@if(!empty(json_decode($item->getProperty('documents'))))
    <div class="mt-[60px]">
        <div class="mb-[30px]">
            <x-inner-heading>{{ __('public.documents') }}</x-inner-heading>
        </div>
        @foreach(json_decode($item->getProperty('documents')) as $document)
            <div class="mb-[40px]">
                <a href="/{{ $document->path }}" target="_blank"
                   class="hover:text-[var(--color-main)] font-semibold text-md transition-all duration-300">
                    @if($document->extension === 'pdf')
                        <i class="fal fa-file-pdf"></i>
                    @elseif($document->extension === 'doc' || $document->extension === 'docx')
                        <i class="fal fa-file-word"></i>
                    @else
                        <i class="fal fa-file"></i>
                    @endif
                    <span class="ml-[10px]">{{ $document->original_name }}</span>
                </a>
            </div>
        @endforeach
    </div>
@endif
