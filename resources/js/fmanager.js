import Alpine from 'alpinejs';
import { Dropzone } from 'dropzone';
import 'compressorjs';

window.Alpine = Alpine;

function fileManager() {
    return {
        //
        // 1. Состояние (state)
        //
        currentPath: '',
        directories: [],
        files: [],
        newFolder: '',
        breadcrumbs: [],
        dropzoneInstance: null,
        selectedFiles: [],

        // Новый параметр: режим отображения файлов ("grid" или "list")
        viewMode: 'grid',

        // Новый параметр: строка поиска
        searchQuery: '',

        contextMenu: {
            show: false,
            x: 0,
            y: 0,
            dir: ''
        },
        fileContextMenu: {
            show: false,
            x: 0,
            y: 0,
            file: null
        },
        previewModal: {
            show: false,
            url: '',
            type: ''
        },

        //
        // 2. Вычисляемые свойства (computed)
        //
        get allFilesSelected() {
            return this.selectedFiles.length === this.filteredFiles.length && this.filteredFiles.length > 0;
        },
        get selectedFilesCount() {
            return this.selectedFiles.length;
        },
        get selectedFilesSize() {
            return this.filteredFiles
                .filter(file => this.selectedFiles.includes(file.path))
                .reduce((sum, file) => sum + file.size, 0);
        },
        get totalFilesCount() {
            return this.filteredFiles.length;
        },
        get totalFilesSize() {
            return this.filteredFiles.reduce((sum, file) => sum + file.size, 0);
        },

        // Новое вычисляемое свойство: список файлов после фильтрации по поиску
        get filteredFiles() {
            if (!this.searchQuery.trim()) {
                return this.files;
            }
            const q = this.searchQuery.trim().toLowerCase();
            return this.files.filter(file => file.name.toLowerCase().includes(q));
        },

        //
        // 3. Методы навигации и получение данных
        //
        fetchFiles() {
            fetch(`/s-files?path=${this.currentPath}`)
                .then(res => res.json())
                .then(data => {
                    this.directories = data.directories;
                    this.files = data.files.map(file => ({
                        name: file.name,
                        size: file.size,
                        path: file.path
                    }));
                    this.updateBreadcrumbs();
                })
                .catch(error => console.error('Error fetching files:', error));
        },

        updateBreadcrumbs() {
            const pathParts = this.currentPath.split('/').filter(part => part !== '');
            this.breadcrumbs = ['root', ...pathParts].filter((item, index, self) => self.indexOf(item) === index);
        },

        goToBreadcrumb(index) {
            this.selectedFiles = [];
            this.currentPath = index === 0
                ? ''
                : this.breadcrumbs.slice(1, index + 1).join('/');
            this.fetchFiles();
        },

        openDirectory(dir) {
            this.selectedFiles = [];
            const dirName = dir.split('/').pop();
            this.currentPath = this.currentPath === ''
                ? dirName
                : (!this.currentPath.includes(dirName) ? `${this.currentPath}/${dirName}` : this.currentPath);
            this.fetchFiles();
        },

        goUp() {
            this.selectedFiles = [];
            if (this.currentPath === '') return;
            const parts = this.currentPath.split('/');
            parts.pop();
            this.currentPath = parts.join('/');
            this.fetchFiles();
        },

        //
        // 4. Методы для работы с папками
        //
        createFolder() {
            if (!this.newFolder.trim()) return;
            const newPath = this.currentPath ? `${this.currentPath}/${this.newFolder}` : this.newFolder;
            fetch('/s-files/create-folder', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                },
                body: JSON.stringify({ path: newPath })
            })
                .then(() => {
                    this.newFolder = '';
                    this.fetchFiles();
                })
                .catch(err => console.error('Ошибка создания папки:', err));
        },

        deleteFolder() {
            if (!confirm('Вы уверены, что хотите удалить папку?')) return;
            fetch('/s-files/delete-folder', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                },
                body: JSON.stringify({ path: this.contextMenu.dir })
            })
                .then(() => {
                    this.fetchFiles();
                    this.updateBreadcrumbs();
                    this.contextMenu.show = false;
                })
                .catch(err => console.error('Ошибка удаления папки:', err));
        },

        copyDirectoryLink() {
            const link = this.contextMenu.dir;
            navigator.clipboard.writeText(link)
                .then(() => alert('Ссылка скопирована: ' + link))
                .catch(err => {
                    console.error('Ошибка копирования ссылки:', err);
                    alert('Не удалось скопировать ссылку');
                });
        },

        //
        // 5. Методы для работы с файлами
        //
        isImage(file) {
            return /\.(jpg|jpeg|png|gif|webp)$/i.test(file.name);
        },

        getFileIcon(file) {
            const ext = file.name.split('.').pop().toLowerCase();
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

        previewFile(file) {
            this.fileContextMenu.show = false;
            const url = `/${file.path}`;
            const extension = file.name.split('.').pop().toLowerCase();
            const isWord = ['doc', 'docx'].includes(extension);
            this.previewModal = {
                show: true,
                url: url,
                type: isWord ? 'word' : this.isImage(file) ? 'image' : extension === 'pdf' ? 'pdf' : 'other'
            };
        },

        deleteFile(file) {
            if (!confirm(`Удалить файл ${file.name}?`)) return;
            fetch('/s-files/delete', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                },
                body: JSON.stringify({ path: file.path })
            })
                .then(() => this.fetchFiles())
                .catch(error => console.error('Ошибка удаления файла:', error));
        },

        deleteSelectedFiles() {
            if (!this.selectedFiles.length || !confirm('Удалить выбранные файлы?')) return;
            const promises = this.selectedFiles.map(path =>
                fetch('/s-files/delete', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                    },
                    body: JSON.stringify({ path })
                })
            );
            Promise.all(promises)
                .then(() => {
                    this.fetchFiles();
                    this.selectedFiles = [];
                })
                .catch(error => console.error('Ошибка удаления нескольких файлов:', error));
        },

        copyFileLink() {
            const file = this.fileContextMenu.file;
            if (!file) return;
            const fileUrl = `/${file.path.replace(/^\//, '')}`;
            navigator.clipboard.writeText(fileUrl)
                .then(() => alert('Ссылка на файл скопирована: ' + fileUrl))
                .catch(err => {
                    console.error('Ошибка копирования ссылки:', err);
                    alert('Не удалось скопировать ссылку');
                });
        },

        passFiles() {
            if (window.opener && !window.opener.closed) {
                window.opener.handleSelectedFiles(this.selectedFiles);
                window.close();
            } else {
                alert("Окно родителя закрыто. Невозможно передать файлы.");
            }
        },

        //
        // 6. Методы выбора (select) файлов
        //
        toggleAllFiles(checked) {
            this.selectedFiles = checked ? this.filteredFiles.map(file => file.path) : [];
        },

        //
        // 7. Новый метод: переключение режима отображения
        //
        toggleView(mode) {
            if (['grid', 'list'].includes(mode)) {
                this.viewMode = mode;
            }
        },

        //
        // 8. Инициализация (Dropzone и начальная загрузка)
        //
        init() {
            this.fetchFiles();

            // Настройка Dropzone
            const self = this;
            Dropzone.autoDiscover = false;
            if (this.dropzoneInstance) {
                this.dropzoneInstance.destroy();
            }
            this.dropzoneInstance = new Dropzone("#uploadZone", {
                paramName: "file",
                maxFilesize: 10,
                transformFile: function (file, done) {
                    if (file.type.startsWith('image/')) {
                        new Compressor(file, {
                            quality: 0.6,
                            maxWidth: 2560,
                            maxHeight: 2560,
                            convertSize: 500000,
                            success(result) {
                                done(result);
                            },
                            error(err) {
                                console.error('Compression error:', err);
                                done(file);
                            }
                        });
                    } else {
                        done(file);
                    }
                },
                renameFile: function (file) {
                    return file.name;
                },
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                },
                init: function () {
                    this.on("success", function (file, response) {
                        self.fetchFiles();
                    });
                    this.on("totaluploadprogress", function (progress) {
                        self.totalProgress = Math.round(progress * 100);
                    });
                }
            });
        },
    };
}

window.fileManager = fileManager;
Alpine.start();
