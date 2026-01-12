<div class="bg-gray-100 w-1/3 xl:w-1/5 h-full overflow-y-auto">
    <div>
        <button @click="goUp()"
                class="p-4 bg-gray-400 text-gray-700 w-full text-xl text-start font-semibold flex items-center justify-between">
            <span>Назад</span>
            <i class="ph ph-arrow-elbow-up-left"></i>
        </button>
    </div>

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

    <div class="relative">
        <ul>
            <template x-for="dir in directories" :key="dir">
                <li>
                    <button
                        @contextmenu.prevent="openDirContextMenu(dir, $event)"
                        @click.stop="openDirectory(dir)"
                        class="flex text-start justify-start items-center border-b w-full py-3 bg-gray-300 px-3 text-lg hover:bg-gray-400 transition-colors">
                        <i class="ph ph-folder mr-2"></i>
                        <span x-text="dir.split('/').pop()"></span>
                    </button>
                </li>
            </template>
        </ul>

        <div x-show="contextMenu.show"
             @click.stop
             :style="`top: ${contextMenu.y}px; left: ${contextMenu.x}px`"
             class="fixed bg-white shadow-lg rounded-md p-2 z-50 border border-gray-200 min-w-[150px]">
            <button @click="copyDirectoryLink(contextMenu.dir); closeContextMenus()"
                    class="flex items-center w-full px-4 py-2 hover:bg-gray-100 rounded-md">
                <i class="ph ph-copy mr-2"></i>
                Копировать путь
            </button>
            <button @click="downloadFolder(contextMenu.dir); closeContextMenus()"
                    class="flex items-center w-full px-4 py-2 hover:bg-gray-100 rounded-md">
                <i class="ph ph-download-simple mr-2"></i>
                Скачать папку
            </button>
            <button @click="openRenameForDir(contextMenu.dir); closeContextMenus()"
                    class="flex items-center w-full px-4 py-2 hover:bg-gray-100 rounded-md">
                <i class="ph ph-pencil-simple mr-2"></i>
                Переименовать
            </button>
            <button @click="deleteFolder(contextMenu.dir); closeContextMenus()"
                    class="flex items-center w-full px-4 py-2 text-red-600 hover:bg-red-50 rounded-md">
                <i class="ph ph-trash mr-2"></i>
                Удалить папку
            </button>
        </div>
    </div>
</div>
