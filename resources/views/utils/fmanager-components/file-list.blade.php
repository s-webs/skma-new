<div class="overflow-auto flex-1 my-8 pb-8">
    {{-- Поле поиска --}}
    <div class="mb-4">
        <input
            type="text"
            x-model="searchQuery"
            placeholder="Поиск по файлам..."
            class="w-full border rounded-md px-3 py-2 focus:outline-none focus:ring focus:border-blue-300"
        >
    </div>

    {{-- Переключатель режима отображения --}}
    <div class="flex items-center justify-end mb-2 space-x-2">
        <button
            @click="toggleView('grid')"
            :class="viewMode === 'grid'
                ? 'bg-gray-700 text-white'
                : 'bg-gray-200 text-gray-700'"
            class="px-3 py-1 rounded-md transition-colors"
        >
            <i class="ph ph-grid"></i>
            <span class="ml-1">Плитка</span>
        </button>
        <button
            @click="toggleView('list')"
            :class="viewMode === 'list'
                ? 'bg-gray-700 text-white'
                : 'bg-gray-200 text-gray-700'"
            class="px-3 py-1 rounded-md transition-colors"
        >
            <i class="ph ph-list"></i>
            <span class="ml-1">Список</span>
        </button>
    </div>

    {{-- Режим "Плитка" --}}
    <ul
        x-show="viewMode === 'grid'"
        class="w-full flex flex-wrap p-2 overflow-auto"
    >
        <template x-for="file in filteredFiles" :key="file.opPath">
            <li class="m-[5px] relative">
                {{-- Чекбокс --}}
                <div class="absolute top-1 left-1 z-[3]">
                    <input type="checkbox"
                           :value="file.opPath"
                           x-model="selectedFiles"
                           class="form-checkbox">
                </div>

                {{-- Превью / иконка файла --}}
                <div
                    @contextmenu.prevent="openFileContextMenu(file, $event)"
                    class="relative"
                >
                    <a :href="fileHref(file)"
                       target="_blank"
                       class="border bg-white w-[120px] h-[120px] flex flex-col justify-between items-center p-2 rounded-md hover:shadow-lg transition-shadow">
                        <template x-if="isImage(file)">
                            <img :src="fileHref(file)"
                                 class="w-full h-[70px] object-cover rounded-md"
                                 alt="Thumbnail">
                        </template>
                        <template x-if="!isImage(file)">
                            <div class="text-4xl text-gray-600">
                                <i :class="getFileIcon(file)"></i>
                            </div>
                        </template>
                        <div class="w-full text-center text-xs truncate">
                            <span x-text="file.name"></span>
                        </div>
                        <div class="w-full text-center text-xs text-gray-500">
                            <span x-text="formatFileSize(file.size)"></span>
                        </div>
                    </a>
                </div>
            </li>
        </template>

        <template x-if="filteredFiles.length === 0">
            <li class="w-full text-center text-gray-500 py-8">
                Файлы не найдены
            </li>
        </template>
    </ul>

    {{-- Режим "Список" --}}
    <ul
        x-show="viewMode === 'list'"
        class="w-full p-2 space-y-2 overflow-auto"
    >
        <template x-for="file in filteredFiles" :key="file.opPath">
            <li class="flex items-center justify-between bg-white border rounded-md px-3 py-2 hover:bg-gray-50 transition-colors relative">
                {{-- Чекбокс --}}
                <div class="mr-3">
                    <input type="checkbox"
                           :value="file.opPath"
                           x-model="selectedFiles"
                           class="form-checkbox">
                </div>

                {{-- Иконка или превью --}}
                <div class="flex items-center flex-1 cursor-pointer"
                     @contextmenu.prevent="openFileContextMenu(file, $event)">

                    <template x-if="isImage(file)">
                        <img :src="fileHref(file)"
                             class="w-[40px] h-[40px] object-cover rounded-md mr-3"
                             alt="Thumbnail">
                    </template>

                    <template x-if="!isImage(file)">
                        <div class="text-2xl text-gray-600 mr-3">
                            <i :class="getFileIcon(file)"></i>
                        </div>
                    </template>

                    {{-- Название и размер --}}
                    <div class="flex-1 overflow-hidden">
                        <a :href="fileHref(file)"
                           target="_blank"
                           class="text-sm font-medium text-gray-700 truncate hover:underline"
                           x-text="file.name"></a>
                        <div class="text-xs text-gray-500">
                            <span x-text="formatFileSize(file.size)"></span>
                        </div>
                    </div>
                </div>

                {{-- Кнопка «еще» (три точки) для быстрого доступа к контекст-меню --}}
                <div>
                    <button
                        @click.prevent="openFileContextMenu(file, $event)"
                        class="text-gray-400 hover:text-gray-600 px-2 py-1 rounded-full transition-colors"
                    >
                        <i class="ph ph-dots-three-outline-vertical text-xl"></i>
                    </button>
                </div>
            </li>
        </template>

        <template x-if="filteredFiles.length === 0">
            <li class="w-full text-center text-gray-500 py-8">
                Файлы не найдены
            </li>
        </template>
    </ul>

    {{-- Пагинация --}}
    <div x-show="pagination.enabled && pagination.totalPages > 1" 
         x-cloak
         class="mt-4 flex items-center justify-center space-x-2"
         style="display: none;">
        <button @click="goToPage(pagination.currentPage - 1)"
                :disabled="pagination.currentPage === 1"
                :class="pagination.currentPage === 1 ? 'opacity-50 cursor-not-allowed' : 'hover:bg-gray-200'"
                class="px-3 py-2 border rounded-md">
            <i class="ph ph-caret-left"></i>
        </button>
        
        <template x-for="page in Array.from({length: Math.min(5, pagination.totalPages)}, (_, i) => {
            const start = Math.max(1, pagination.currentPage - 2);
            return start + i;
        }).filter(p => p <= pagination.totalPages)" :key="page">
            <button @click="goToPage(page)"
                    :class="page === pagination.currentPage 
                        ? 'bg-gray-700 text-white' 
                        : 'bg-white hover:bg-gray-100'"
                    class="px-3 py-2 border rounded-md min-w-[40px]">
                <span x-text="page"></span>
            </button>
        </template>

        <button @click="goToPage(pagination.currentPage + 1)"
                :disabled="pagination.currentPage === pagination.totalPages"
                :class="pagination.currentPage === pagination.totalPages ? 'opacity-50 cursor-not-allowed' : 'hover:bg-gray-200'"
                class="px-3 py-2 border rounded-md">
            <i class="ph ph-caret-right"></i>
        </button>

        <span class="text-sm text-gray-600 ml-4">
            Страница <span x-text="pagination.currentPage"></span> из <span x-text="pagination.totalPages"></span>
            (<span x-text="pagination.total"></span> файлов)
        </span>
    </div>
</div>
