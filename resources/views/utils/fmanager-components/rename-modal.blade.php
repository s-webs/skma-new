<div x-show="renameModal.show"
     x-cloak
     class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-[120]"
     @click.self="closeRenameModal()">
    <div class="bg-white p-6 rounded-lg shadow-lg w-[90vw] max-w-[520px]">
        <div class="flex items-start justify-between">
            <div>
                <h2 class="text-lg font-bold"
                    x-text="renameModal.type === 'file' ? 'Переименовать файл' : 'Переименовать папку'"></h2>
                <p class="text-sm text-gray-500 mt-1">
                    Текущее имя: <span class="font-medium text-gray-700" x-text="renameModal.displayName"></span>
                </p>
            </div>

            <button class="text-gray-500 hover:text-gray-800"
                    @click="closeRenameModal()">
                <i class="ph ph-x text-xl"></i>
            </button>
        </div>

        <div class="mt-4">
            <label class="block text-sm text-gray-600 mb-1">Новое имя</label>
            <input type="text"
                   class="w-full border rounded-md px-3 py-2 focus:outline-none focus:ring"
                   x-model="renameModal.newName"
                   @keydown.enter.prevent="submitRename()"
                   autofocus>
            <p class="text-xs text-gray-500 mt-2">
                Для файла: если не указать расширение — сохранится старое.
            </p>
        </div>

        <div class="mt-5 flex justify-end gap-2">
            <button class="px-4 py-2 rounded-md bg-gray-200 hover:bg-gray-300"
                    @click="closeRenameModal()">
                Отмена
            </button>
            <button class="px-4 py-2 rounded-md bg-gray-800 text-white hover:bg-gray-900"
                    @click="submitRename()">
                Переименовать
            </button>
        </div>
    </div>
</div>
