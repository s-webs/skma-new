<div x-show="fileContextMenu.show"
     :style="`top: ${fileContextMenu.y + 5}px; left: ${fileContextMenu.x + 5}px`"
     class="fixed bg-white shadow-lg rounded-md p-2 z-50 border border-gray-200 min-w-[150px]">

    {{-- Кнопка закрыть (крестик) в правом верхнем углу --}}
    <button @click="fileContextMenu.show = false"
            class="w-full text-gray-500 hover:text-gray-800 text-end">
        <i class="ph ph-x text-lg"></i>
    </button>

    <button @click="previewFile(fileContextMenu.file)"
            class="flex items-center w-full px-4 py-2 hover:bg-gray-100 rounded-md">
        <i class="ph ph-eye mr-2"></i>
        Просмотр
    </button>
    <button @click="copyFileLink(); fileContextMenu.show = false"
            class="flex items-center w-full px-4 py-2 hover:bg-gray-100 rounded-md">
        <i class="ph ph-copy mr-2"></i>
        Копировать ссылку
    </button>
    <button @click="deleteFile(fileContextMenu.file); fileContextMenu.show = false"
            class="flex items-center w-full px-4 py-2 text-red-600 hover:bg-red-50 rounded-md">
        <i class="ph ph-trash mr-2"></i>
        Удалить
    </button>
</div>
