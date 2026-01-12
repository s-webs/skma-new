<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use MoonShine\Laravel\MoonShineAuth;

class FilesController extends Controller
{
    private \Illuminate\Contracts\Filesystem\Filesystem $disk;

    // Диск, где реально лежат файлы
    private string $selectedDisk = 'uploads';

    // Публичный префикс (как вы сейчас формируете ссылки на файлы)
    private string $selectedDir = 'uploads';

    public function __construct()
    {
        if (!MoonShineAuth::getGuard()->check()) {
            abort(401);
        }

        $this->disk = Storage::disk($this->selectedDisk);
    }

    private function normalizePath(?string $path): string
    {
        $path = (string)($path ?? '');
        $path = trim($path);

        // Единый разделитель
        $path = str_replace('\\', '/', $path);

        // Убираем ведущие слэши
        $path = ltrim($path, '/');

        // Убираем двойные слэши
        $path = preg_replace('#/+#', '/', $path);

        // Блокируем traversal
        if (str_contains($path, '..')) {
            abort(422, 'Invalid path');
        }

        return $path;
    }

    private function stripPublicPrefix(string $path): string
    {
        $path = $this->normalizePath($path);

        $prefix = rtrim($this->selectedDir, '/') . '/';
        if ($prefix !== '/' && str_starts_with($path, $prefix)) {
            $path = substr($path, strlen($prefix));
        }

        return $path;
    }

    private function publicPath(string $diskPath): string
    {
        $diskPath = $this->normalizePath($diskPath);
        return rtrim($this->selectedDir, '/') . ($diskPath !== '' ? '/' . $diskPath : '');
    }

    public function index()
    {
        return view('utils.filemanager');
    }

    public function files(Request $request)
    {
        $path = $this->normalizePath($request->query('path', ''));

        try {
            $directories = $this->disk->directories($path);
            sort($directories, SORT_NATURAL | SORT_FLAG_CASE);

            $files = [];
            foreach ($this->disk->files($path) as $file) {
                $files[] = [
                    'name' => basename($file),
                    'size' => (int)$this->disk->size($file),
                    // disk-relative путь для операций (delete/rename/etc)
                    'disk_path' => $file,
                    // public путь для открытия в браузере
                    'public_path' => $this->publicPath($file),
                    // backward compatibility: ваш текущий фронт читает file.path
                    'path' => $this->publicPath($file),
                ];
            }

            usort($files, fn($a, $b) => strnatcasecmp($a['name'], $b['name']));

            return response()->json([
                'path' => $path,
                'directories' => $directories,
                'files' => $files
            ]);
        } catch (\Throwable $e) {
            // Если прилетел “кривой” путь/директория — лучше вернуть пустой список, чем падать
            return response()->json([
                'path' => $path,
                'directories' => [],
                'files' => [],
                'error' => 'Unable to read directory'
            ], 200);
        }
    }

    public function createFolder(Request $request)
    {
        $request->validate(['path' => 'required|string']);

        $path = $this->normalizePath($request->input('path'));
        if ($path === '') {
            abort(422, 'Empty path');
        }

        $this->disk->makeDirectory($path);
        return response()->json(['success' => true]);
    }

    public function deleteFolder(Request $request)
    {
        $request->validate(['path' => 'required|string']);

        $path = $this->normalizePath($request->input('path'));
        if ($path === '') {
            abort(422, 'Refuse to delete root');
        }

        $this->disk->deleteDirectory($path);
        return response()->json(['success' => true]);
    }

    public function upload(Request $request)
    {
        $request->validate([
            'file' => 'required|file|max:10240',
            'path' => 'nullable|string'
        ]);

        $file = $request->file('file');
        $path = $this->normalizePath($request->input('path', ''));

        // Оригинальное имя
        $filename = $file->getClientOriginalName();

        // Убираем опасные символы
        $filename = preg_replace([
            '/\//',
            '/\x00/',
            '/[\x00-\x1F\x7F]/',
            '/[\/:\\|<>?*"]/'
        ], '_', $filename);

        $counter = 1;
        $originalName = pathinfo($filename, PATHINFO_FILENAME);
        $extension = pathinfo($filename, PATHINFO_EXTENSION);

        $probe = $path !== '' ? ($path . '/' . $filename) : $filename;

        while ($this->disk->exists($probe)) {
            $filename = $extension
                ? "{$originalName} ({$counter}).{$extension}"
                : "{$originalName} ({$counter})";

            $probe = $path !== '' ? ($path . '/' . $filename) : $filename;
            $counter++;
        }

        $filePath = $file->storeAs(
            $path,
            $filename,
            $this->selectedDisk
        );

        return response()->json([
            'success' => true,
            'disk_path' => $filePath,
            'public_path' => $this->publicPath($filePath),
            'filename' => $filename
        ]);
    }

    public function delete(Request $request)
    {
        $request->validate(['path' => 'required|string']);

        // Принимаем как disk_path, так и public_path — и приводим к disk-relative
        $diskPath = $this->stripPublicPrefix($request->input('path'));

        if ($diskPath === '') {
            return response()->json(['error' => 'Invalid file path'], 422);
        }

        if ($this->disk->exists($diskPath)) {
            $this->disk->delete($diskPath);
            return response()->json(['success' => true]);
        }

        return response()->json(['error' => 'File not found'], 404);
    }

    public function downloadFolder(Request $request)
    {
        if (!class_exists(\ZipArchive::class)) {
            abort(500, 'ZipArchive is not available (php-zip extension missing).');
        }

        $path = $this->normalizePath($request->query('path', ''));

        // Чтобы случайно не архивировать весь корень
        if ($path === '') {
            abort(422, 'Path is required');
        }

        if (!$this->disk->directoryExists($path)) {
            abort(404, 'Directory not found');
        }

        @set_time_limit(0);

        $folderName = basename($path);
        $zipName = $folderName . '.zip';

        // Временный файл
        $tmp = tempnam(sys_get_temp_dir(), 'sfiles_zip_');
        $zipPath = $tmp . '.zip';
        @rename($tmp, $zipPath);

        $zip = new \ZipArchive();
        $opened = $zip->open($zipPath, \ZipArchive::CREATE | \ZipArchive::OVERWRITE);
        if ($opened !== true) {
            abort(500, 'Unable to create zip');
        }

        // Чтобы внутри архива всё лежало в папке <folderName>/
        $root = $folderName;
        $zip->addEmptyDir($root);

        // Добавляем пустые директории
        foreach ($this->disk->allDirectories($path) as $dir) {
            $rel = ltrim(substr($dir, strlen($path)), '/');
            if ($rel === '') continue;
            $zip->addEmptyDir($root . '/' . $rel);
        }

        // Добавляем файлы
        foreach ($this->disk->allFiles($path) as $file) {
            $rel = ltrim(substr($file, strlen($path)), '/');
            $entryName = $root . '/' . $rel;

            // Если диск локальный — лучше addFile (не грузит файл в память)
            try {
                $absPath = Storage::disk($this->selectedDisk)->path($file);
                if (is_file($absPath)) {
                    $zip->addFile($absPath, $entryName);
                    continue;
                }
            } catch (\Throwable $e) {
                // fallback ниже
            }

            // Fallback для не-local: читаем содержимое и кладём в zip
            $zip->addFromString($entryName, $this->disk->get($file));
        }

        $zip->close();

        return response()
            ->download($zipPath, $zipName, ['Content-Type' => 'application/zip'])
            ->deleteFileAfterSend(true);
    }

    public function downloadFiles(Request $request)
    {
        if (!class_exists(\ZipArchive::class)) {
            abort(500, 'ZipArchive is not available (php-zip extension missing).');
        }

        $paths = $request->input('paths', []);

        if (!is_array($paths) || count($paths) === 0) {
            abort(422, 'No files selected');
        }

        // ограничение, чтобы не убить сервер
        if (count($paths) > 300) {
            abort(422, 'Too many files selected');
        }

        // Приводим входные пути к disk-relative
        $diskPaths = [];
        foreach ($paths as $p) {
            if (!is_string($p)) continue;

            $diskPath = $this->stripPublicPrefix($p);
            $diskPath = $this->normalizePath($diskPath);

            if ($diskPath === '') continue;

            if (!$this->disk->exists($diskPath)) {
                // можно "skip", но для предсказуемости лучше ругаться
                abort(404, "File not found: {$diskPath}");
            }

            $diskPaths[] = $diskPath;
        }

        if (count($diskPaths) === 0) {
            abort(404, 'Files not found');
        }

        @set_time_limit(0);

        $zipName = 'files_' . date('Y-m-d_H-i-s') . '.zip';

        // Временный файл
        $tmp = tempnam(sys_get_temp_dir(), 'sfiles_zip_');
        $zipPath = $tmp . '.zip';
        @rename($tmp, $zipPath);

        $zip = new \ZipArchive();
        $opened = $zip->open($zipPath, \ZipArchive::CREATE | \ZipArchive::OVERWRITE);
        if ($opened !== true) {
            abort(500, 'Unable to create zip');
        }

        // Папка внутри архива
        $root = 'files';
        $zip->addEmptyDir($root);

        // Чтобы не было конфликтов имён в архиве
        $used = [];

        foreach ($diskPaths as $diskPath) {
            $base = basename($diskPath);
            $entry = $base;

            $key = mb_strtolower($entry);
            if (isset($used[$key])) {
                $pi = pathinfo($base);
                $stem = $pi['filename'] ?? $base;
                $ext = isset($pi['extension']) && $pi['extension'] !== '' ? '.' . $pi['extension'] : '';

                $i = 1;
                do {
                    $entry = "{$stem} ({$i}){$ext}";
                    $key = mb_strtolower($entry);
                    $i++;
                } while (isset($used[$key]));
            }

            $used[$key] = true;

            $zipEntryName = $root . '/' . $entry;

            // Если диск локальный — addFile (не тащит файл в память)
            try {
                $absPath = Storage::disk($this->selectedDisk)->path($diskPath);
                if (is_file($absPath)) {
                    $zip->addFile($absPath, $zipEntryName);
                    continue;
                }
            } catch (\Throwable $e) {
                // fallback ниже
            }

            // Fallback для не-local
            $zip->addFromString($zipEntryName, $this->disk->get($diskPath));
        }

        $zip->close();

        return response()
            ->download($zipPath, $zipName, ['Content-Type' => 'application/zip'])
            ->deleteFileAfterSend(true);
    }

    private function sanitizeName(string $name): string
    {
        $name = trim($name);

        // запрещаем путь, разрешаем только имя
        $name = str_replace(['\\', '/'], '_', $name);

        // нулевые байты и управляющие символы
        $name = preg_replace('/\x00|[\x00-\x1F\x7F]/u', '_', $name);

        // спецсимволы, которые часто ломают FS/URL
        $name = preg_replace('/[<>:"|?*]/u', '_', $name);

        // схлопываем пробелы
        $name = preg_replace('/\s+/u', ' ', $name);

        return trim($name);
    }

    private function moveDirectory(string $from, string $to): void
    {
        $from = $this->normalizePath($from);
        $to = $this->normalizePath($to);

        // создать корневую папку назначения
        if (!$this->disk->directoryExists($to)) {
            $this->disk->makeDirectory($to);
        }

        // создать все подпапки
        foreach ($this->disk->allDirectories($from) as $dir) {
            $rel = ltrim(substr($dir, strlen($from)), '/');
            if ($rel !== '') {
                $this->disk->makeDirectory($to . '/' . $rel);
            }
        }

        // перенести все файлы
        foreach ($this->disk->allFiles($from) as $file) {
            $rel = ltrim(substr($file, strlen($from)), '/');
            $this->disk->move($file, $to . '/' . $rel);
        }

        // удалить исходную папку
        $this->disk->deleteDirectory($from);
    }


    public function rename(Request $request)
    {
        $request->validate([
            'type' => 'required|in:file,dir',
            'path' => 'required|string',
            'new_name' => 'required|string|max:255',
        ]);

        $type = $request->input('type');

        // path может прийти как disk_path ("docs/a.pdf") или public_path ("uploads/docs/a.pdf")
        $oldDiskPath = $this->stripPublicPrefix($request->input('path'));
        $oldDiskPath = $this->normalizePath($oldDiskPath);

        if ($oldDiskPath === '') {
            return response()->json(['error' => 'Invalid path'], 422);
        }

        $newName = $this->sanitizeName($request->input('new_name'));

        if ($newName === '' || $newName === '.' || $newName === '..') {
            return response()->json(['error' => 'Invalid name'], 422);
        }

        $parent = dirname($oldDiskPath);
        $parent = ($parent === '.' ? '' : $parent);

        // Для файла: если пользователь ввёл имя без расширения — сохраняем старое расширение
        if ($type === 'file') {
            if (!$this->disk->exists($oldDiskPath)) {
                return response()->json(['error' => 'File not found'], 404);
            }

            $oldExt = pathinfo($oldDiskPath, PATHINFO_EXTENSION);
            $newExt = pathinfo($newName, PATHINFO_EXTENSION);

            if ($oldExt && !$newExt) {
                $newName = $newName . '.' . $oldExt;
            }
        }

        // Для папки: проверяем существование директории
        if ($type === 'dir') {
            if (!$this->disk->directoryExists($oldDiskPath)) {
                return response()->json(['error' => 'Directory not found'], 404);
            }
        }

        $newDiskPath = $parent !== '' ? ($parent . '/' . $newName) : $newName;

        // no-op
        if ($newDiskPath === $oldDiskPath) {
            return response()->json([
                'success' => true,
                'old_path' => $oldDiskPath,
                'new_path' => $newDiskPath,
                'public_path' => $type === 'file' ? $this->publicPath($newDiskPath) : null,
            ]);
        }

        // конфликт имён
        if ($this->disk->exists($newDiskPath) || $this->disk->directoryExists($newDiskPath)) {
            return response()->json(['error' => 'Target already exists'], 409);
        }

        if ($type === 'file') {
            $this->disk->move($oldDiskPath, $newDiskPath);
        } else {
            $this->moveDirectory($oldDiskPath, $newDiskPath);
        }

        return response()->json([
            'success' => true,
            'old_path' => $oldDiskPath,
            'new_path' => $newDiskPath,
            'public_path' => $type === 'file' ? $this->publicPath($newDiskPath) : null,
        ]);
    }

}
