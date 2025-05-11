import Alpine from 'alpinejs';
import {Dropzone} from "dropzone";
import 'compressorjs';

window.Alpine = Alpine;

function fileManager() {
    return {
        currentPath: '',
        directories: [],
        files: [],
        newFolder: '',
        breadcrumbs: [],
        dropzoneInstance: null,
        selectedFiles: [],
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
        contextMenu: {
            show: false,
            x: 0,
            y: 0,
            dir: ''
        },

        // Получение файлов и директорий с сервера
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

        // Выбор/отмена выбора всех файлов
        toggleAllFiles(checked) {
            this.selectedFiles = checked ? this.files.map(file => file.path) : [];
        },

        get allFilesSelected() {
            return this.selectedFiles.length === this.files.length && this.files.length > 0;
        },

        get selectedFilesCount() {
            return this.selectedFiles.length;
        },

        get selectedFilesSize() {
            return this.files
                .filter(file => this.selectedFiles.includes(file.path))
                .reduce((sum, file) => sum + file.size, 0);
        },

        get totalFilesCount() {
            return this.files.length;
        },

        get totalFilesSize() {
            return this.files.reduce((sum, file) => sum + file.size, 0);
        },

        passFiles() {
            if (window.opener && !window.opener.closed) {
                // Вызываем функцию в родительском окне и передаём выбранные файлы
                window.opener.handleSelectedFiles(this.selectedFiles);
                // Закрываем окно файлового менеджера после передачи данных
                window.close();
            } else {
                alert("Окно родителя закрыто. Невозможно передать файлы.");
            }
        },

        updateBreadcrumbs() {
            const pathParts = this.currentPath.split('/').filter(part => part !== '');
            this.breadcrumbs = ['root', ...pathParts];
            this.breadcrumbs = this.breadcrumbs.filter((item, index, self) => self.indexOf(item) === index);
        },

        goToBreadcrumb(index) {
            this.selectedFiles = [];
            this.currentPath = index === 0 ? '' : this.breadcrumbs.slice(1, index + 1).join('/');
            this.fetchFiles();
            this.updateBreadcrumbs();
        },

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

        getDirectoryLink() {
            // Базовый URL берём из window.location.origin
            let baseUrl = window.location.origin;
            // Формируем ссылку согласно маршруту вашего файлового менеджера.
            // Если текущий путь пустой, значит мы на корневой директории.
            let link = `${baseUrl}/s-files`;
            if (this.currentPath && this.currentPath.trim() !== '') {
                link += `?path=${encodeURIComponent(this.currentPath)}`;
            }
            return link;
        },

        copyDirectoryLink() {
            const baseUrl = window.location.origin;
            let link = this.contextMenu.dir;
            navigator.clipboard.writeText(link)
                .then(() => {
                    alert('Ссылка скопирована: ' + link);
                })
                .catch(err => {
                    console.error('Ошибка копирования ссылки:', err);
                });
        },

        copyFileLink() {
            const file = this.fileContextMenu.file;
            if (!file) return;

            // Убираем window.location.origin
            const fileUrl = `/${file.path.replace(/^\//, '')}`;  // Удаляем начальный слеш если есть

            navigator.clipboard.writeText(fileUrl)
                .then(() => {
                    alert('Ссылка на файл скопирована: ' + fileUrl);
                })
                .catch(err => {
                    console.error('Ошибка копирования ссылки:', err);
                    alert('Не удалось скопировать ссылку');
                });
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

        createFolder() {
            const newPath = this.currentPath ? `${this.currentPath}/${this.newFolder}` : this.newFolder;
            fetch('/s-files/create-folder', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                },
                body: JSON.stringify({path: newPath})
            }).then(() => {
                this.newFolder = '';
                this.fetchFiles();
            });
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
                body: JSON.stringify({path: file.path})
            })
                .then(() => this.fetchFiles())
                .catch(error => console.error('Ошибка удаления:', error));
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
                    body: JSON.stringify({path})
                })
            );
            Promise.all(promises)
                .then(() => {
                    this.fetchFiles();
                    this.selectedFiles = [];
                })
                .catch(error => console.error('Ошибка удаления:', error));
        },

        deleteFolder() {
            if (!confirm('Вы уверены, что хотите удалить папку?')) return;
            fetch('/s-files/delete-folder', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
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
            const self = this;
            Dropzone.autoDiscover = false;
            if (this.dropzoneInstance) this.dropzoneInstance.destroy();
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
