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
    class="h-full"
    @click="closeContextMenus()"
    @keydown.escape.window="closeAllPopups()"
    x-ref="fmRoot"
>

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
