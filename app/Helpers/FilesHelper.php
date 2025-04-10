<?php

use Illuminate\Support\Facades\Storage;

if (!function_exists('scanDirectory')) {
    /**
     * Рекурсивно сканирует директорию и возвращает структуру вида:
     *
     * [
     *   'directory_name' => 'Имя текущей директории',
     *   'files'          => [
     *       ['filename' => 'file1.pdf', 'path' => 'UMKD/1. Бакалавриат/1. Бакалавриат - Силлабусы/file1.pdf'],
     *       ...
     *   ],
     *   'subdirectories' => [
     *       // Узлы для вложенных директорий (по тому же формату)
     *   ]
     * ]
     *
     * Если указан параметр $skipTopLevels, то первые уровни (например, «УМКД» и первый уровень после него)
     * не будут включены в итоговую структуру – их детей сразу поднимаем вверх.
     *
     * @param string $directory      Путь к директории, например "/UMKD/1. Бакалавриат/1. Бакалавриат - Силлабусы"
     * @param string $disk           Название диска (по умолчанию 'uploads')
     * @param int $skipTopLevels     Сколько верхних уровней пропустить (например, 2, чтобы не включать «УМКД» и первый уровень)
     * @param int $maxDepth          Максимальная глубина рекурсии (по умолчанию 999)
     * @param int $level             Текущий уровень (служебный параметр, по умолчанию 0)
     *
     * @return array Структура директории, либо массив узлов при пропуске уровней
     */
    function scanDirectory(
        string $directory,
        string $disk = 'uploads',
        int $skipTopLevels = 0,
        int $maxDepth = 999,
        int $level = 0
    ): array {
        // Убираем начальные и конечные слеши
        $directory = trim($directory, '/');
        // Имя текущей директории – просто базовое имя (без накопления родительских имен)
        $currentDirName = $directory ? basename($directory) : 'root';

        // Если превышена максимальная глубина, прекращаем рекурсию
        if ($level > $maxDepth) {
            return [];
        }

        // Получаем список непосредственных поддиректорий текущей директории
        $subdirectories = Storage::disk($disk)->directories($directory);

        // Если текущий уровень должен быть пропущен, не формируем узел для него,
        // а возвращаем детей, объединёнными в один массив.
        if ($level < $skipTopLevels) {
            $results = [];
            if (!empty($subdirectories)) {
                foreach ($subdirectories as $subdir) {
                    $childData = scanDirectory($subdir, $disk, $skipTopLevels, $maxDepth, $level + 1);
                    // Если $childData – одиночный узел (ассоциативный массив с ключом directory_name)
                    // добавляем его, иначе объединяем массив узлов
                    if (isset($childData['directory_name'])) {
                        $results[] = $childData;
                    } else {
                        $results = array_merge($results, $childData);
                    }
                }
            } else {
                // Если поддиректорий нет – получаем файлы текущей директории
                $files = Storage::disk($disk)->files($directory);
                $mappedFiles = array_map(function ($file) {
                    return [
                        'filename' => basename($file),
                        'path'     => $file,
                    ];
                }, $files);
                $results[] = [
                    'directory_name' => $currentDirName,
                    'files'          => $mappedFiles,
                    'subdirectories' => [],
                ];
            }
            return $results;
        }

        // Если текущий уровень не пропускается – формируем узел для этой директории
        $node = [
            'directory_name' => $currentDirName,
            'files'          => [],
            'subdirectories' => [],
        ];

        if (!empty($subdirectories)) {
            foreach ($subdirectories as $subdir) {
                $childNode = scanDirectory($subdir, $disk, $skipTopLevels, $maxDepth, $level + 1);
                // childNode может быть одиночным узлом или массивом узлов – объединяем результат
                if (isset($childNode['directory_name'])) {
                    $node['subdirectories'][] = $childNode;
                } else {
                    $node['subdirectories'] = array_merge($node['subdirectories'], $childNode);
                }
            }
        } else {
            // Если вложенных директорий нет – получаем файлы
            $files = Storage::disk($disk)->files($directory);
            $node['files'] = array_map(function ($file) {
                return [
                    'filename' => basename($file),
                    'path'     => $file,
                ];
            }, $files);
        }

        return $node;
    }
}
