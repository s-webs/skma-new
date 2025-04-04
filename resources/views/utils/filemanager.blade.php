<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Файловый менеджер S-Files</title>

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/dropzone/5.9.3/dropzone.min.css">
    <link
        rel="stylesheet"
        type="text/css"
        href="https://cdn.jsdelivr.net/npm/@phosphor-icons/web@2.1.1/src/regular/style.css"
    />
    <link
        rel="stylesheet"
        type="text/css"
        href="https://cdn.jsdelivr.net/npm/@phosphor-icons/web@2.1.1/src/fill/style.css"
    />
    <script src="https://unpkg.com/alpinejs" defer></script>
    @vite(['resources/css/filemanager.css'])
</head>
<body class="overflow-hidden h-screen w-full">

<div x-data="fileManager()" class="h-full" @click.away="contextMenu.show = false">
    <div class="bg-gray-700">
        <h1 class="text-2xl p-4 text-white font-semibold">S-FILES</h1>
    </div>

    <div class="flex h-full">
        <div class="bg-gray-100 w-1/5 h-full">
            <div class="">
                <button @click="goUp()"
                        class="p-4 bg-gray-400 text-gray-700 w-full text-xl text-start font-semibold flex items-center justify-between">
                    <span>Назад</span>
                    <i class="ph ph-arrow-elbow-up-left"></i>
                </button>
            </div>
            <div class="flex items-center">
                <input type="text" placeholder="Создать директорию" x-model="newFolder" class="border-none flex-1"/>
                <button @click="createFolder()" class="bg-gray-700 py-2 px-4 font-semibold text-white">Создать</button>
            </div>
            <div x-data="{ contextMenu: { show: false, x: 0, y: 0, dir: '' } }"
                 @click.away="contextMenu.show = false"
                 class="relative">

                <!-- Список директорий с правым кликом -->
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
                                class="flex items-center border-b w-full py-3 bg-gray-300 px-3 text-lg hover:bg-gray-400 transition-colors">
                                <i class="ph ph-folder mr-1"></i>
                                <span x-text="dir.split('/').pop()"></span>
                            </button>
                        </li>
                    </template>
                </ul>

                <!-- Само контекстное меню -->
                <div
                    x-show="contextMenu.show"
                    :style="`top: ${contextMenu.y + 5}px; left: ${contextMenu.x + 5}px`"
                    class="fixed bg-white shadow-lg rounded-md p-2 z-50 border border-gray-200 min-w-[150px]">
                    <button
                        @click="deleteFolder()"
                        class="flex items-center w-full px-4 py-2 text-red-600 hover:bg-red-50 rounded-md">
                        <i class="ph ph-trash mr-2"></i>
                        Удалить папку
                    </button>
                </div>
            </div>
        </div>
        <div class="p-4 flex-1 overflow-hidden flex flex-col justify-between">
            <div class="px-4 py-2 bg-gray-100 rounded-[10px]">
                <template x-for="(part, index) in breadcrumbs" :key="index">
                    <div class="inline-flex items-center">
                        <a href="#"
                           @click.prevent="goToBreadcrumb(index)"
                           :class="index === breadcrumbs.length - 1
                   ? 'text-gray-700 cursor-default'
                   : 'text-gray-500 hover:text-gray-700'"
                           class="transition-colors">
                            <template x-if="part === 'root'">
                                <i class="ph ph-house-simple text-lg"></i>
                            </template>
                            <template x-if="part !== 'root'">
                                <span x-text="part"></span>
                            </template>
                        </a>
                        <i x-show="index < breadcrumbs.length - 1"
                           class="ph ph-caret-right mx-2 text-gray-400 text-sm"></i>
                    </div>
                </template>
            </div>
            <div class="flex items-center mt-2">
                <!-- Модальное окно -->
                <div x-data="{ showModal: false }">
                    <button @click="showModal = true"
                            class="bg-gray-700 px-6 py-3 text-white font-semibold rounded-md">
                        Загрузить файлы
                    </button>

                    <div x-show="showModal"
                         class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center">
                        <div class="bg-white p-6 rounded-lg shadow-lg w-1/2">
                            <h2 class="text-lg font-bold mb-4">Загрузите файлы</h2>

                            <form action="/files/upload" class="dropzone h-[300px] overflow-auto" id="uploadZone">
                                <input type="hidden" name="path" x-model="currentPath">
                                @csrf
                            </form>


                            <!-- Кнопка закрытия -->
                            <button @click="showModal = false" class="mt-4 bg-red-500 text-white px-4 py-2 rounded-md">
                                Закрыть
                            </button>
                        </div>
                    </div>
                </div>
            </div>
            <div class="overflow-auto flex-1 my-8 pb-8">  <!-- Установите желаемую высоту -->
                <ul class="w-full flex flex-wrap p-2 overflow-auto">
                    <template x-for="file in files" :key="file.path">
                        <li class="m-[5px]">
                            <a :href="'/' + file.path" target="_blank"
                               class="border bg-white w-[120px] h-[120px] flex flex-col justify-between items-center p-2 rounded-md">
                                <template x-if="isImage(file)">
                                    <img :src="'/' + file.path" class="w-full h-[70px] object-cover rounded-md"
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
                                    <span x-text="formatFileSize(file.size)"></span> <!-- Добавляем размер файла -->
                                </div>
                            </a>
                        </li>
                    </template>
                </ul>
            </div>
        </div>
    </div>
    {{--    <form action="/files/upload" class="dropzone" id="uploadZone">--}}
    {{--        <input type="hidden" name="path" x-model="currentPath">--}}
    {{--        @csrf--}}
    {{--    </form>--}}
</div>

<script src="https://cdnjs.cloudflare.com/ajax/libs/dropzone/5.9.3/dropzone.min.js"></script>
<script>
    function fileManager() {
        return {
            currentPath: '',
            directories: [],
            files: [],
            newFolder: '',
            breadcrumbs: [],

            contextMenu: {
                show: false,
                x: 0,
                y: 0,
                dir: ''
            },

            fetchFiles() {
                fetch(`/files?path=${this.currentPath}`)
                    .then(res => res.json())
                    .then(data => {
                        this.directories = data.directories;
                        this.files = data.files.map(file => ({
                            name: file.name,
                            size: file.size,
                            path: file.path
                        }));
                        this.updateBreadcrumbs();
                    });
            },

            updateBreadcrumbs() {
                // Разбиваем путь и удаляем пустые элементы
                const pathParts = this.currentPath.split('/').filter(part => part !== '');

                // Всегда начинаем с 'root' и добавляем только уникальные части пути
                this.breadcrumbs = ['root', ...pathParts];

                // Удаляем дубликаты, сохраняя порядок
                this.breadcrumbs = this.breadcrumbs.filter((item, index, self) => {
                    return self.indexOf(item) === index;
                });
            },

            goToBreadcrumb(index) {
                if (index === 0) {
                    // Клик по корневой директории (root)
                    this.currentPath = '';
                } else {
                    // Берем части пути начиная с 1 элемента (после root) до выбранного индекса
                    const parts = this.breadcrumbs.slice(1, index + 1);
                    this.currentPath = parts.join('/');
                }

                // Обновляем данные и хлебные крошки
                this.fetchFiles();
                this.updateBreadcrumbs();
            },

            isImage(file) {
                return /\.(jpg|jpeg|png|gif|webp)$/i.test(file.name);
            },

            getFileIcon(file) {
                let ext = file.name.split('.').pop().toLowerCase();
                const icons = {
                    pdf: 'ph ph-file-pdf text-red-500',
                    docx: 'ph ph-file-doc text-blue-500',
                    xlsx: 'ph ph-file-xls text-green-500',
                    pptx: 'ph ph-file-ppt text-orange-500',
                    zip: 'ph ph-file-zip text-gray-500',
                    default: 'ph ph-file text-gray-500'
                };
                return icons[ext] || icons.default;
            },

            formatFileSize(size) {
                if (size < 1024) return size + ' B';
                else if (size < 1048576) return (size / 1024).toFixed(2) + ' KB';
                else if (size < 1073741824) return (size / 1048576).toFixed(2) + ' MB';
                else return (size / 1073741824).toFixed(2) + ' GB';
            },

            openDirectory(dir) {
                // Получаем только имя директории из полного пути
                const dirName = dir.split('/').pop();

                // Корректно формируем новый путь
                if (this.currentPath === '') {
                    this.currentPath = dirName;
                } else {
                    // Проверяем, не содержится ли dirName уже в текущем пути
                    if (!this.currentPath.includes(dirName)) {
                        this.currentPath = `${this.currentPath}/${dirName}`;
                    }
                }
                this.fetchFiles();
            },

            goUp() {
                if (this.currentPath === '') return;
                let parts = this.currentPath.split('/');
                parts.pop();
                this.currentPath = parts.join('/');
                this.fetchFiles();
            },

            createFolder() {
                const newPath = this.currentPath
                    ? `${this.currentPath}/${this.newFolder}`
                    : this.newFolder;

                fetch('/files/create-folder', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('input[name="_token"]').value
                    },
                    body: JSON.stringify({path: newPath})
                }).then(() => {
                    this.newFolder = '';
                    this.fetchFiles();
                });
            },

            deleteFile(file) {
                fetch('/files/delete', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('input[name="_token"]').value
                    },
                    body: JSON.stringify({path: file.path})
                }).then(() => this.fetchFiles());
            },

            deleteFolder() {
                if (!confirm('Вы уверены, что хотите удалить папку?')) return;
                fetch('/files/delete-folder', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('input[name="_token"]').value
                    },
                    body: JSON.stringify({path: this.contextMenu.dir})
                })
                    .then(() => {
                        this.fetchFiles();
                        this.updateBreadcrumbs();
                        this.contextMenu.show = false;
                    });
            },

            init() {
                this.fetchFiles();
                Dropzone.options.uploadZone = {
                    paramName: "file",
                    maxFilesize: 10,
                    init: function () {
                        this.on("success", () => fileManager().fetchFiles());
                    }
                };
            }
        };
    }

</script>
</body>
</html>
