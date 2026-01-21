<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Файловый менеджер S-Files</title>

    <!-- Иконки Phosphor -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@phosphor-icons/web@2.1.1/src/regular/style.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@phosphor-icons/web@2.1.1/src/fill/style.css">

    <!-- Ваши стили -->
    @vite(['resources/css/filemanager.css'])
</head>
<body class="overflow-hidden h-screen w-full">

{{-- Alpine-компонент инициализируется здесь --}}
<div
    x-data="fileManager()"
    x-init="init()"
    class="h-full relative"
    @click="closeContextMenus()"
    @keydown.escape.window="closeAllPopups()"
    @dragover.prevent="handleDragOver($event)"
    @dragleave.prevent="handleDragLeave($event)"
    @drop.prevent="handleDrop($event)"
    x-ref="fmRoot"
    :class="dragOver ? 'bg-blue-50' : ''"
>
    {{-- Уведомления --}}
    <div x-show="notification.show"
         x-cloak
         x-transition:enter="transition ease-out duration-300"
         x-transition:enter-start="opacity-0 transform translate-y-2"
         x-transition:enter-end="opacity-100 transform translate-y-0"
         x-transition:leave="transition ease-in duration-200"
         x-transition:leave-start="opacity-100"
         x-transition:leave-end="opacity-0"
         class="fixed top-4 right-4 z-[200] max-w-md"
         :class="{
             'bg-green-500': notification.type === 'success',
             'bg-red-500': notification.type === 'error',
             'bg-yellow-500': notification.type === 'warning',
             'bg-blue-500': notification.type === 'info'
         }"
         style="display: none;">
        <div class="p-4 rounded-lg shadow-lg text-white">
            <div class="flex items-center justify-between">
                <p x-text="notification.message" class="font-medium"></p>
                <button @click="notification.show = false" class="ml-4 text-white hover:text-gray-200">
                    <i class="ph ph-x"></i>
                </button>
            </div>
        </div>
    </div>

    {{-- Индикатор загрузки операций --}}
    <div x-show="operationLoading"
         x-cloak
         class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-[150]"
         style="display: none;">
        <div class="bg-white p-6 rounded-lg shadow-lg">
            <div class="flex items-center space-x-3">
                <div class="animate-spin rounded-full h-8 w-8 border-b-2 border-gray-900"></div>
                <span class="text-lg font-medium">Выполнение операции...</span>
            </div>
        </div>
    </div>

    {{-- Drag & Drop зона --}}
    <div x-show="dragOver"
         x-cloak
         class="fixed inset-0 bg-blue-500 bg-opacity-20 border-4 border-dashed border-blue-500 z-[140] flex items-center justify-center"
         style="display: none;">
        <div class="text-center">
            <i class="ph ph-cloud-arrow-up text-6xl text-blue-500 mb-4"></i>
            <p class="text-2xl font-bold text-blue-700">Перетащите файлы сюда для загрузки</p>
        </div>
    </div>

    <div class="flex h-screen">

        {{-- Левое меню директорий --}}
        @include('utils.fmanager-components.sidebar')

        {{-- Правая область: хлебные крошки, тулбар, file-list, и т. д. --}}
        <div class="p-4 flex-1 max-h-[93vh] overflow-hidden flex flex-col justify-between relative">
            @include('utils.fmanager-components.breadcrumbs')
            @include('utils.fmanager-components.toolbar')

            {{--  ЭТОТ include ДОЛЖЕН БЫТЬ ВНУТРИ альпайновского контейнера --}}
            @include('utils.fmanager-components.file-list')

            @include('utils.fmanager-components.file-context-menu')
            @include('utils.fmanager-components.preview-modal')
            @include('utils.fmanager-components.rename-modal')
            @include('utils.fmanager-components.footer')
        </div>
    </div>
</div>

{{-- Скрипт Alpine + ваш скрипт с fileManager() --}}
@vite(['resources/js/fmanager.js'])
</body>

</html>
