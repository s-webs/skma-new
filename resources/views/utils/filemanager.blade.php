<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Файловый менеджер S-Files</title>
    <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/@phosphor-icons/web@2.1.1/src/regular/style.css">
    <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/@phosphor-icons/web@2.1.1/src/fill/style.css">
    @vite(['resources/css/filemanager.css'])
</head>
<body class="overflow-hidden h-screen w-full">
<div x-data="fileManager()" class="h-full" @click.away="contextMenu.show = false">
    <div class="flex h-screen">
        <!-- Боковая панель (директории) -->
        <div class="bg-gray-100 w-1/3 xl:w-1/5 h-full overflow-y-auto">
            <div>
                <button @click="goUp()"
                        class="p-4 bg-gray-400 text-gray-700 w-full text-xl text-start font-semibold flex items-center justify-between">
                    <span>Назад</span>
                    <i class="ph ph-arrow-elbow-up-left"></i>
                </button>
            </div>
            <div class="flex items-center justify-between flex-wrap">
                <input type="text" placeholder="Создать директорию" x-model="newFolder" class="border-none"/>
                <button @click="createFolder()" class="bg-gray-800 py-2 px-4 font-semibold text-white">Создать</button>
            </div>
            <div x-data="{ contextMenu: { show: false, x: 0, y: 0, dir: '' } }"
                 @click.away="contextMenu.show = false"
                 class="relative">
                <!-- Список директорий с правым кликом -->
                <ul>
                    <template x-for="dir in directories" :key="dir">
                        <li class="">
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
                <!-- Контекстное меню для папок -->
                <div x-show="contextMenu.show"
                     :style="`top: ${contextMenu.y + 5}px; left: ${contextMenu.x + 5}px`"
                     class="fixed bg-white shadow-lg rounded-md p-2 z-50 border border-gray-200 min-w-[150px]">
                    <!-- Кнопка копирования ссылки -->
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
        <!-- Основная область (файлы, хлебные крошки, действия) -->
        <div class="p-4 flex-1 max-h-[93vh] overflow-hidden flex flex-col justify-between relative">
            <div class="px-4 py-2 bg-gray-100 rounded-[10px]">
                <template x-for="(part, index) in breadcrumbs" :key="index">
                    <div class="inline-flex items-center">
                        <a href="#"
                           @click.prevent="goToBreadcrumb(index)"
                           :class="index === breadcrumbs.length - 1 ? 'text-gray-700 cursor-default' : 'text-gray-500 hover:text-gray-700'"
                           class="transition-colors">
                            <template x-if="part === 'root'">
                                <i class="ph ph-house text-lg"></i>
                            </template>
                            <template x-if="part !== 'root'">
                                <span x-text="part"></span>
                            </template>
                        </a>
                        <i x-show="index < breadcrumbs.length - 1" class="ph ph-caret-right mx-2 text-gray-400 text-sm"></i>
                    </div>
                </template>
            </div>
            <div class="flex justify-between items-center mt-2">
                <!-- Модальное окно для загрузки файлов -->
                <div x-data="{ showModal: false }">
                    <button @click="showModal = true" class="bg-gray-700 px-6 py-3 text-white font-semibold rounded-md">
                        Загрузить файлы
                    </button>
                    <div x-show="showModal" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-[5]">
                        <div class="bg-white p-6 rounded-lg shadow-lg w-1/2">
                            <h2 class="text-lg font-bold mb-4">Загрузите файлы</h2>
                            <form action="/s-files/upload" class="dropzone h-[300px] overflow-auto" id="uploadZone">
                                <input type="hidden" name="path" x-model="currentPath">
                                @csrf
                            </form>
                            <button @click="showModal = false" class="mt-4 bg-red-500 text-white px-4 py-2 rounded-md">
                                Закрыть
                            </button>
                        </div>
                    </div>
                </div>
                <!-- Панель действий с файлами -->
                <div class="flex items-center">
                    <label class="flex items-center bg-blue-500 disabled:opacity-50 disabled:cursor-not-allowed px-6 py-3 text-white font-semibold rounded-md mr-4">
                        <input type="checkbox" @change="toggleAllFiles($event.target.checked)" x-bind:checked="allFilesSelected" class="form-checkbox mr-4">
                        Выбрать все
                    </label>
                    <button @click="deleteSelectedFiles()" :disabled="!selectedFiles.length"
                            class="bg-red-500 disabled:opacity-50 disabled:cursor-not-allowed px-6 py-3 text-white font-semibold rounded-md">
                        Удалить выбранное (<span x-text="selectedFiles.length"></span>)
                    </button>
                </div>
            </div>
            <!-- Область файлов -->
            <div class="overflow-auto flex-1 my-8 pb-8">
                <ul class="w-full flex flex-wrap p-2 overflow-auto">
                    <template x-for="file in files" :key="file.path">
                        <li class="m-[5px] relative">
                            <div class="absolute top-1 left-1 z-[3]">
                                <input type="checkbox" :value="file.path" x-model="selectedFiles" class="form-checkbox">
                            </div>
                            <div @contextmenu.prevent="
                                    fileContextMenu.file = file;
                                    fileContextMenu.show = true;
                                    fileContextMenu.x = $event.clientX;
                                    fileContextMenu.y = $event.clientY;
                                " class="relative">
                                <a :href="'/' + file.path" target="_blank"
                                   class="border bg-white w-[120px] h-[120px] flex flex-col justify-between items-center p-2 rounded-md">
                                    <template x-if="isImage(file)">
                                        <img :src="'/' + file.path" class="w-full h-[70px] object-cover rounded-md" alt="Thumbnail">
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
                    <!-- Контекстное меню для файла -->
                    <div x-show="fileContextMenu.show"
                         :style="`top: ${fileContextMenu.y + 5}px; left: ${fileContextMenu.x + 5}px`"
                         class="fixed bg-white shadow-lg rounded-md p-2 z-50 border border-gray-200 min-w-[150px]">
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
                    <!-- Модальное окно предпросмотра -->
                    <div x-show="previewModal.show"
                         class="fixed inset-0 bg-black bg-opacity-70 flex items-center justify-center z-[100]">
                        <div class="bg-gray-700 w-[90vw] p-6 rounded-lg shadow-lg overflow-auto">
                            <button @click="previewModal.show = false"
                                    class="absolute top-4 right-4 text-white hover:text-gray-300 w-[60px] h-[60px] bg-gray-700 text-2xl rounded-full">
                                <i class="ph ph-x"></i>
                            </button>
                            <template x-if="previewModal.type === 'image'">
                                <img :src="previewModal.url" class="max-w-full max-h-[80vh] mx-auto">
                            </template>
                            <template x-if="previewModal.type === 'pdf'">
                                <embed :src="previewModal.url" type="application/pdf" width="100%" height="600px">
                            </template>
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
                            <template x-if="previewModal.type === 'other'">
                                <div class="text-center p-4">
                                    <i class="ph ph-file text-4xl text-gray-400"></i>
                                    <p class="mt-2">Предпросмотр недоступен</p>
                                    <a :href="previewModal.url" download class="text-blue-500 hover:underline mt-4 inline-block">
                                        <i class="ph ph-download"></i> Скачать файл
                                    </a>
                                </div>
                            </template>
                        </div>
                    </div>
                </ul>
            </div>
            <!-- Футер с информацией о файлах -->
            <div class="absolute right-0 bottom-0 w-full bg-gray-200">
                <div class="flex items-center justify-between px-4 py-3 text-sm text-gray-400">
                    <div>
                        <button @click="passFiles()" class="bg-green-600 px-4 py-2 text-white rounded-md">
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
        </div>
    </div>
</div>
@vite(['resources/js/fmanager.js'])
</body>
</html>
