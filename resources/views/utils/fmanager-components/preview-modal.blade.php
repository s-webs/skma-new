<div x-show="previewModal.show"
     class="fixed inset-0 bg-black bg-opacity-70 flex items-center justify-center z-[100]">
    <div class="bg-gray-700 w-[90vw] p-6 rounded-lg shadow-lg overflow-auto relative">
        <button @click="previewModal.show = false"
                class="absolute top-4 right-4 text-white hover:text-gray-300 w-[60px] h-[60px] bg-gray-700 text-2xl rounded-full">
            <i class="ph ph-x"></i>
        </button>

        {{-- Предпросмотр изображений --}}
        <template x-if="previewModal.type === 'image'">
            <img :src="previewModal.url"
                 class="max-w-full max-h-[80vh] mx-auto"
                 alt="Preview">
        </template>

        {{-- Предпросмотр PDF --}}
        <template x-if="previewModal.type === 'pdf'">
            <embed :src="previewModal.url"
                   type="application/pdf"
                   width="100%"
                   height="600px">
        </template>

        {{-- Предпросмотр Word-документа через Google Docs Viewer --}}
        <template x-if="previewModal.type === 'word'">
            <div class="w-full h-[80vh]">
                <iframe :src="`https://docs.google.com/gview?url=${encodeURIComponent(previewModal.url)}&embedded=true`"
                        class="w-full h-full" frameborder="0"></iframe>
                <div class="mt-2 text-center">
                    <a :href="previewModal.url" download class="text-blue-500 hover:underline">
                        <i class="ph ph-download"></i> Скачать оригинал
                    </a>
                </div>
            </div>
        </template>

        {{-- Если предпросмотр невозможен --}}
        <template x-if="previewModal.type === 'other'">
            <div class="text-center p-4">
                <i class="ph ph-file text-4xl text-gray-400"></i>
                <p class="mt-2">Предпросмотр недоступен</p>
                <a :href="previewModal.url"
                   download
                   class="text-blue-500 hover:underline mt-4 inline-block">
                    <i class="ph ph-download"></i> Скачать файл
                </a>
            </div>
        </template>
    </div>
</div>
