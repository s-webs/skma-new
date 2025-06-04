<div class="bg-gray-100 w-1/3 xl:w-1/5 h-full overflow-y-auto">
    {{-- Кнопка "Назад" --}}
    <div>
        <button @click="goUp()"
                class="p-4 bg-gray-400 text-gray-700 w-full text-xl text-start font-semibold flex items-center justify-between">
            <span>Назад</span>
            <i class="ph ph-arrow-elbow-up-left"></i>
        </button>
    </div>

    {{-- Поле создания новой папки --}}
    <div class="flex items-center justify-between flex-wrap p-3">
        <input type="text"
               placeholder="Создать директорию"
               x-model="newFolder"
               class="border-none flex-1 mr-2 py-2 px-3 rounded-md bg-white"/>
        <button @click="createFolder()"
                class="bg-gray-800 py-2 px-4 font-semibold text-white rounded-md">
            Создать
        </button>
    </div>

    {{-- Список директорий с поддержкой контекстного меню --}}
    <div x-data="{ contextMenu: { show: false, x: 0, y: 0, dir: '' } }"
         @click.away="contextMenu.show = false"
         class="relative">
        <ul>
            <template x-for="dir in directories" :key="dir">
                <li>
                    <button
                        @contextmenu.prevent="
                            contextMenu.dir = dir;
                            contextMenu.show = true;
                            contextMenu.x = $event.clientX;
                            contextMenu.y = $event.clientY;
                        "
                        @click="openDirectory(dir)"
                        class="flex text-start justify-start items-center border-b w-full py-3 bg-gray-300 px-3 text-lg hover:bg-gray-400 transition-colors">
                        <i class="ph ph-folder mr-2"></i>
                        <span x-text="dir.split('/').pop()"></span>
                    </button>
                </li>
            </template>
        </ul>

        {{-- Контекстное меню для директории --}}
        <div x-show="contextMenu.show"
             :style="`top: ${contextMenu.y + 5}px; left: ${contextMenu.x + 5}px`"
             class="fixed bg-white shadow-lg rounded-md p-2 z-50 border border-gray-200 min-w-[150px]">
            <button @click="copyDirectoryLink(); contextMenu.show = false"
                    class="flex items-center w-full px-4 py-2 hover:bg-gray-100 rounded-md">
                <i class="ph ph-copy mr-2"></i>
                Копировать ссылку
            </button>
            <button @click="deleteFolder()"
                    class="flex items-center w-full px-4 py-2 text-red-600 hover:bg-red-50 rounded-md">
                <i class="ph ph-trash mr-2"></i>
                Удалить папку
            </button>
        </div>
    </div>
</div>
