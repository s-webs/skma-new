<div class="absolute right-0 bottom-0 w-full bg-gray-200">
    <div class="flex items-center justify-between px-4 py-3 text-sm text-gray-400">
        <div>
            <button @click="passFiles()"
                    class="bg-green-600 px-4 py-2 text-white rounded-md">
                Передать выбранные файлы
            </button>
        </div>
        <div class="flex items-center">
            <div class="border-gray-400 border-r px-2 mr-2">
                Выбрано: <span x-text="selectedFilesCount"></span>
            </div>
            <div class="border-gray-400 border-r px-2 mr-2">
                Размер выбранных: <span x-text="formatFileSize(selectedFilesSize)"></span>
            </div>
            <div class="border-gray-400 border-r px-2 mr-2">
                Всего файлов: <span x-text="totalFilesCount"></span>
            </div>
            <div class="border-gray-400 border-r px-2 mr-2">
                Общий размер: <span x-text="formatFileSize(totalFilesSize)"></span>
            </div>
        </div>
    </div>
</div>
