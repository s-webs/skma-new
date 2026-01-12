import Alpine from 'alpinejs';
import Dropzone from 'dropzone';
import 'dropzone/dist/dropzone.css';
import Compressor from 'compressorjs';

window.Alpine = Alpine;

function fileManager() {
    return {
        // 1) State
        currentPath: '',
        directories: [],
        files: [],
        newFolder: '',
        breadcrumbs: [],
        dropzoneInstance: null,
        selectedFiles: [],

        viewMode: 'grid',
        searchQuery: '',

        loading: false,
        lastError: null,
        totalProgress: 0,

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

        renameModal: {
            show: false,
            type: 'file',     // 'file' | 'dir'
            path: '',         // file.opPath или dir (disk-relative)
            displayName: '',  // текущее имя для UI
            newName: ''       // ввод пользователя
        },

        // 2) Computed
        get filteredFiles() {
            if (!this.searchQuery.trim()) return this.files;
            const q = this.searchQuery.trim().toLowerCase();
            return this.files.filter(file => file.name.toLowerCase().includes(q));
        },

        get allFilesSelected() {
            return this.filteredFiles.length > 0 && this.selectedFiles.length === this.filteredFiles.length;
        },

        get selectedFilesCount() {
            return this.selectedFiles.length;
        },

        // ВАЖНО: считаем размер выбранных по this.files, а не filteredFiles (чтобы поиск не “обнулял” размер)
        get selectedFilesSize() {
            return this.files
                .filter(file => this.selectedFiles.includes(file.opPath))
                .reduce((sum, file) => sum + (Number(file.size) || 0), 0);
        },

        // ВАЖНО: “Всего файлов/размер” должны быть по всем файлам папки, а не по фильтру
        get totalFilesCount() {
            return this.files.length;
        },

        get totalFilesSize() {
            return this.files.reduce((sum, file) => sum + (Number(file.size) || 0), 0);
        },

        // 3) Utils
        csrfToken() {
            return document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || '';
        },

        buildPublicUrl(publicPathOrPath) {
            const p = String(publicPathOrPath || '').replace(/^\/+/, '');
            return '/' + p;
        },

        closeContextMenus() {
            this.contextMenu.show = false;
            this.fileContextMenu.show = false;
        },

        closeAllPopups() {
            this.closeContextMenus();
            this.previewModal.show = false;
            this.renameModal.show = false;
        },


        setMenuPosition(menuObj, clientX, clientY) {
            // Простая “защита” от выезда за экран (оценочно)
            const menuW = 190;
            const menuH = 160;

            const maxX = window.innerWidth - menuW;
            const maxY = window.innerHeight - menuH;

            menuObj.x = Math.max(8, Math.min(clientX, maxX));
            menuObj.y = Math.max(8, Math.min(clientY, maxY));
        },

        openDirContextMenu(dir, event) {
            event.preventDefault();
            this.fileContextMenu.show = false;

            this.contextMenu.dir = dir;
            this.setMenuPosition(this.contextMenu, event.clientX + 5, event.clientY + 5);
            this.contextMenu.show = true;
        },

        openFileContextMenu(file, event) {
            event.preventDefault();
            this.contextMenu.show = false;

            this.fileContextMenu.file = file;
            this.setMenuPosition(this.fileContextMenu, event.clientX + 5, event.clientY + 5);
            this.fileContextMenu.show = true;
        },

        async apiFetch(url, options = {}) {
            const headers = options.headers || {};
            const res = await fetch(url, {
                credentials: 'same-origin',
                ...options,
                headers: {
                    ...headers,
                }
            });

            const text = await res.text();
            let data = null;
            try {
                data = text ? JSON.parse(text) : null;
            } catch (e) {
                data = {raw: text};
            }

            if (!res.ok) {
                const msg = data?.message || data?.error || `HTTP ${res.status}`;
                throw new Error(msg);
            }

            return data;
        },

        // 4) Data loading / navigation
        async fetchFiles() {
            this.loading = true;
            this.lastError = null;
            this.closeContextMenus();

            try {
                const data = await this.apiFetch(`/s-files?path=${encodeURIComponent(this.currentPath)}`);

                this.directories = Array.isArray(data?.directories) ? data.directories : [];

                // Приводим файлы к единому виду:
                // publicPath -> для ссылок
                // opPath -> для операций (delete/rename/etc): disk_path приоритетнее
                this.files = (Array.isArray(data?.files) ? data.files : []).map(f => {
                    const publicPath = f.public_path || f.path || '';
                    const opPath = f.disk_path || f.diskPath || publicPath; // fallback
                    return {
                        name: f.name,
                        size: Number(f.size) || 0,
                        publicPath,
                        opPath
                    };
                });

                this.updateBreadcrumbs();
            } catch (e) {
                console.error('Error fetching files:', e);
                this.lastError = e?.message || 'Error fetching files';
                this.directories = [];
                this.files = [];
                this.updateBreadcrumbs();
            } finally {
                this.loading = false;
            }
        },

        updateBreadcrumbs() {
            const parts = this.currentPath.split('/').filter(Boolean);
            this.breadcrumbs = ['root', ...parts];
        },

        goToBreadcrumb(index) {
            this.selectedFiles = [];
            this.closeContextMenus();

            this.currentPath = index === 0 ? '' : this.breadcrumbs.slice(1, index + 1).join('/');
            this.fetchFiles();
        },

        openDirectory(dir) {
            this.selectedFiles = [];
            this.closeContextMenus();

            // ВАЖНО: backend отдаёт dir как disk-relative путь, значит просто присваиваем
            this.currentPath = dir || '';
            this.fetchFiles();
        },

        goUp() {
            this.selectedFiles = [];
            this.closeContextMenus();

            if (this.currentPath === '') return;
            const parts = this.currentPath.split('/');
            parts.pop();
            this.currentPath = parts.join('/');
            this.fetchFiles();
        },

        // 5) Folder ops
        async createFolder() {
            const name = this.newFolder.trim();
            if (!name) return;

            const newPath = this.currentPath ? `${this.currentPath}/${name}` : name;

            try {
                await this.apiFetch('/s-files/create-folder', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': this.csrfToken()
                    },
                    body: JSON.stringify({path: newPath})
                });

                this.newFolder = '';
                await this.fetchFiles();
            } catch (e) {
                console.error('Ошибка создания папки:', e);
                alert(e?.message || 'Ошибка создания папки');
            }
        },

        async deleteFolder(dir) {
            const target = String(dir || '').trim();
            if (!target) return;

            if (!confirm('Вы уверены, что хотите удалить папку?')) return;

            try {
                await this.apiFetch('/s-files/delete-folder', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': this.csrfToken()
                    },
                    body: JSON.stringify({path: target})
                });

                this.contextMenu.show = false;
                await this.fetchFiles();
            } catch (e) {
                console.error('Ошибка удаления папки:', e);
                alert(e?.message || 'Ошибка удаления папки');
            }
        },

        copyDirectoryLink(dir) {
            const target = String(dir || '').trim();
            if (!target) return;

            navigator.clipboard.writeText(target)
                .then(() => alert('Путь скопирован: ' + target))
                .catch(err => {
                    console.error('Ошибка копирования:', err);
                    alert('Не удалось скопировать');
                });
        },

        downloadFolder(dir) {
            const target = String(dir || '').trim();
            if (!target) return;

            this.closeContextMenus();

            // прямой переход — браузер начнет скачивание
            window.location.href = `/s-files/download-folder?path=${encodeURIComponent(target)}`;
        },

        // Rename
        openRenameForFile(file) {
            if (!file) return;
            this.closeContextMenus();

            this.renameModal = {
                show: true,
                type: 'file',
                path: file.opPath,         // важно: для операций используем opPath (disk_path)
                displayName: file.name,
                newName: file.name
            };
        },

        openRenameForDir(dir) {
            const target = String(dir || '').trim();
            if (!target) return;
            this.closeContextMenus();

            const name = target.split('/').filter(Boolean).pop() || target;

            this.renameModal = {
                show: true,
                type: 'dir',
                path: target,             // dirs у вас уже disk-relative
                displayName: name,
                newName: name
            };
        },

        closeRenameModal() {
            this.renameModal.show = false;
        },

        async submitRename() {
            const newName = String(this.renameModal.newName || '').trim();
            if (!newName) return;

            try {
                await this.apiFetch('/s-files/rename', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': this.csrfToken()
                    },
                    body: JSON.stringify({
                        type: this.renameModal.type,
                        path: this.renameModal.path,
                        new_name: newName
                    })
                });

                // Чтобы не держать устаревшие пути
                this.selectedFiles = [];
                this.renameModal.show = false;

                await this.fetchFiles();
            } catch (e) {
                console.error('Ошибка переименования:', e);
                alert(e?.message || 'Ошибка переименования');
            }
        },

        // 6) File helpers / ops
        isImage(file) {
            return /\.(jpg|jpeg|png|gif|webp)$/i.test(file.name);
        },

        getFileIcon(file) {
            const ext = file.name.split('.').pop().toLowerCase();
            const icons = {
                pdf: 'ph ph-file-pdf text-red-500',
                doc: 'ph ph-file-doc text-blue-500',
                docx: 'ph ph-file-doc text-blue-500',
                xlsx: 'ph ph-file-xls text-green-500',
                pptx: 'ph ph-file-ppt text-orange-500',
                zip: 'ph ph-file-zip text-gray-500',
                default: 'ph ph-file text-gray-500'
            };
            return icons[ext] || icons.default;
        },

        formatFileSize(size) {
            const s = Number(size) || 0;
            if (s < 1024) return s + ' B';
            if (s < 1048576) return (s / 1024).toFixed(2) + ' KB';
            if (s < 1073741824) return (s / 1048576).toFixed(2) + ' MB';
            return (s / 1073741824).toFixed(2) + ' GB';
        },

        fileHref(file) {
            return this.buildPublicUrl(file.publicPath);
        },

        previewFile(file) {
            this.fileContextMenu.show = false;

            const url = this.fileHref(file);
            const extension = file.name.split('.').pop().toLowerCase();
            const isWord = ['doc', 'docx'].includes(extension);

            this.previewModal = {
                show: true,
                url,
                type: isWord ? 'word' : this.isImage(file) ? 'image' : extension === 'pdf' ? 'pdf' : 'other'
            };
        },

        async deleteFile(file) {
            if (!confirm(`Удалить файл ${file.name}?`)) return;

            try {
                // Для операций используем opPath (disk_path приоритетнее)
                await this.apiFetch('/s-files/delete', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': this.csrfToken()
                    },
                    body: JSON.stringify({path: file.opPath})
                });

                await this.fetchFiles();
                this.selectedFiles = this.selectedFiles.filter(p => p !== file.opPath);
            } catch (e) {
                console.error('Ошибка удаления файла:', e);
                alert(e?.message || 'Ошибка удаления файла');
            }
        },

        async deleteSelectedFiles() {
            if (!this.selectedFiles.length || !confirm('Удалить выбранные файлы?')) return;

            const paths = [...this.selectedFiles];

            try {
                await Promise.all(paths.map(path =>
                    this.apiFetch('/s-files/delete', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': this.csrfToken()
                        },
                        body: JSON.stringify({path})
                    })
                ));

                this.selectedFiles = [];
                await this.fetchFiles();
            } catch (e) {
                console.error('Ошибка удаления нескольких файлов:', e);
                alert(e?.message || 'Ошибка удаления нескольких файлов');
            }
        },

        downloadSelectedFiles() {
            if (!this.selectedFiles.length) return;

            // Чтобы не уводить текущую страницу при скачивании — отправляем в новую вкладку
            const form = document.createElement('form');
            form.method = 'POST';
            form.action = '/s-files/download-files';
            form.target = '_blank';
            form.style.display = 'none';

            const csrf = document.createElement('input');
            csrf.type = 'hidden';
            csrf.name = '_token';
            csrf.value = this.csrfToken();
            form.appendChild(csrf);

            this.selectedFiles.forEach(p => {
                const input = document.createElement('input');
                input.type = 'hidden';
                input.name = 'paths[]';
                input.value = p; // у вас selectedFiles уже хранит opPath (disk_path)
                form.appendChild(input);
            });

            document.body.appendChild(form);
            form.submit();
            form.remove();
        },

        copyFileLink() {
            const file = this.fileContextMenu.file;
            if (!file) return;

            const url = this.fileHref(file);

            navigator.clipboard.writeText(url)
                .then(() => alert('Ссылка на файл скопирована: ' + url))
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

        // 7) Selection
        toggleAllFiles(checked) {
            // Выбираем только видимые (filtered) — логично для UX
            this.selectedFiles = checked ? this.filteredFiles.map(file => file.opPath) : [];
        },

        // 8) View
        toggleView(mode) {
            if (['grid', 'list'].includes(mode)) this.viewMode = mode;
        },

        // 9) Init
        init() {
            this.fetchFiles();

            const self = this;

            Dropzone.autoDiscover = false;

            if (this.dropzoneInstance) {
                this.dropzoneInstance.destroy();
            }

            this.dropzoneInstance = new Dropzone("#uploadZone", {
                url: "/s-files/upload",
                paramName: "file",
                maxFilesize: 10, // MB
                withCredentials: true,
                timeout: 120000,

                transformFile: function (file, done) {
                    if (file.type && file.type.startsWith('image/')) {
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
                    'X-CSRF-TOKEN': self.csrfToken()
                },

                init: function () {
                    this.on("sending", function (file, xhr, formData) {
                        formData.append("path", self.currentPath);
                        self.totalProgress = 0; // сброс перед стартом
                    });

                    // прогресс по каждому файлу — визуально плавнее
                    this.on("uploadprogress", function (file, progress) {
                        self.totalProgress = Math.round(progress);
                    });

                    // общий прогресс очереди (можете оставить, если хотите)
                    this.on("totaluploadprogress", function (progress) {
                        self.totalProgress = Math.round(progress);
                    });

                    this.on("success", function () {
                        self.fetchFiles();
                    });

                    // когда вся очередь завершена — сброс прогресса через небольшую паузу
                    this.on("queuecomplete", function () {
                        setTimeout(() => {
                            self.totalProgress = 0;
                        }, 500);
                    });

                    this.on("error", function (file, message, xhr) {
                        console.error("Dropzone error:", {
                            name: file?.name,
                            status: xhr?.status,
                            message,
                            response: xhr?.responseText
                        });
                    });
                }
            });
        },
    };
}

window.fileManager = fileManager;
Alpine.start();
