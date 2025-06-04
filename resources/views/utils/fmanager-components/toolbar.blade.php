<div class="flex justify-between items-center mt-2">
    {{-- Кнопка "Загрузить файлы" + модальное окно --}}
    <div x-data="{ showModal: false }">
        <button @click="showModal = true"
                class="bg-gray-700 px-6 py-3 text-white font-semibold rounded-md">
            Загрузить файлы
        </button>
        <div x-show="showModal"
             class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-[5]">
            <div class="bg-white p-6 rounded-lg shadow-lg w-1/2">
                <h2 class="text-lg font-bold mb-4">Загрузите файлы</h2>
                <form action="/s-files/upload"
                      class="dropzone h-[300px] overflow-auto"
                      id="uploadZone">
                    <input type="hidden" name="path" x-model="currentPath">
                    @csrf
                </form>
                <button @click="showModal = false"
                        class="mt-4 bg-red-500 text-white px-4 py-2 rounded-md">
                    Закрыть
                </button>
            </div>
        </div>
    </div>

    {{-- Выбор всех и удаление --}}
    <div class="flex items-center">
        <label class="flex items-center bg-blue-500 disabled:opacity-50 disabled:cursor-not-allowed px-6 py-3 text-white font-semibold rounded-md mr-4">
            <input type="checkbox"
                   @change="toggleAllFiles($event.target.checked)"
                   :checked="allFilesSelected"
                   class="form-checkbox mr-4">
            Выбрать все
        </label>
        <button @click="deleteSelectedFiles()"
                :disabled="!selectedFiles.length"
                class="bg-red-500 disabled:opacity-50 disabled:cursor-not-allowed px-6 py-3 text-white font-semibold rounded-md">
            Удалить выбранное (<span x-text="selectedFiles.length"></span>)
        </button>
    </div>
</div>
