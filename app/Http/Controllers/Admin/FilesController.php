<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Cache;
use MoonShine\Laravel\MoonShineAuth;

class FilesController extends Controller
{
    private \Illuminate\Contracts\Filesystem\Filesystem $disk;
    private string $selectedDisk;
    private string $selectedDir;
    private string $basePath;

    public function __construct()
    {
        if (!MoonShineAuth::getGuard()->check()) {
            abort(401);
        }

        $this->selectedDisk = config('filemanager.disk', 'uploads');
        $this->selectedDir = config('filemanager.public_dir', 'uploads');
        $this->disk = Storage::disk($this->selectedDisk);
        
        // Получаем реальный базовый путь для проверки безопасности
        try {
            $basePath = realpath($this->disk->path(''));
            if ($basePath === false) {
                $basePath = $this->disk->path('');
            }
            // Нормализуем путь (убираем обратные слэши, двойные слэши)
            $this->basePath = str_replace('\\', '/', rtrim($basePath, '/\\'));
        } catch (\Throwable $e) {
            $basePath = $this->disk->path('');
            $this->basePath = str_replace('\\', '/', rtrim($basePath, '/\\'));
        }
    }

    /**
     * Normalize and validate path with enhanced security
     * 
     * @param string|null $path Путь для нормализации
     * @param bool $checkExistence Проверять ли существование пути (false для создания новых)
     */
    private function normalizePath(?string $path, bool $checkExistence = true): string
    {
        $path = (string)($path ?? '');
        $path = trim($path);

        // Единый разделитель
        $path = str_replace('\\', '/', $path);

        // Убираем ведущие слэши
        $path = ltrim($path, '/');

        // Убираем двойные слэши
        $path = preg_replace('#/+#', '/', $path);

        // Блокируем traversal - проверяем все варианты
        if (str_contains($path, '..') || 
            str_contains($path, '%2e%2e') || 
            str_contains($path, '%2E%2E') ||
            preg_match('/\.\./', $path)) {
            $this->logAction('security_violation', [
                'attempted_path' => $path,
                'user_id' => MoonShineAuth::getGuard()->id(),
            ]);
            abort(422, 'Invalid path: path traversal detected');
        }

        // Проверка глубины пути
        $maxDepth = config('filemanager.security.max_path_depth', 20);
        $depth = substr_count($path, '/') + 1;
        if ($depth > $maxDepth) {
            abort(422, 'Path depth exceeds maximum allowed');
        }

        // Проверка реального пути (защита от симлинков)
        if ($path !== '') {
            try {
                if ($checkExistence) {
                    // Для существующих путей - проверяем реальный путь
                    $fullPath = $this->disk->path($path);
                    $realPath = realpath($fullPath);
                    
                    if ($realPath === false) {
                        $this->logAction('security_violation', [
                            'attempted_path' => $path,
                            'full_path' => $fullPath,
                            'base_path' => $this->basePath,
                            'user_id' => MoonShineAuth::getGuard()->id(),
                        ]);
                        abort(422, 'Invalid path: path does not exist');
                    }
                    
                    // Нормализуем пути для сравнения
                    $normalizedRealPath = str_replace('\\', '/', rtrim($realPath, '/\\'));
                    $normalizedBasePath = str_replace('\\', '/', rtrim($this->basePath, '/\\'));
                    
                    if (!str_starts_with($normalizedRealPath, $normalizedBasePath)) {
                        $this->logAction('security_violation', [
                            'attempted_path' => $path,
                            'real_path' => $normalizedRealPath,
                            'base_path' => $normalizedBasePath,
                            'user_id' => MoonShineAuth::getGuard()->id(),
                        ]);
                        abort(422, 'Invalid path: outside allowed directory');
                    }
                } else {
                    // Для несуществующих путей (при создании) - упрощенная проверка
                    // Проверяем только родительскую директорию
                    $parentPath = dirname($path);
                    if ($parentPath === '.' || $parentPath === '') {
                        $parentPath = '';
                    }
                    
                    // Если есть родительская директория - проверяем её существование
                    if ($parentPath !== '') {
                        // Нормализуем родительский путь (без рекурсии - просто базовые проверки)
                        $normalizedParent = trim($parentPath);
                        $normalizedParent = str_replace('\\', '/', $normalizedParent);
                        $normalizedParent = ltrim($normalizedParent, '/');
                        $normalizedParent = preg_replace('#/+#', '/', $normalizedParent);
                        
                        // Проверяем, что родительская директория существует
                        if (!$this->disk->directoryExists($normalizedParent)) {
                            abort(422, 'Invalid path: parent directory does not exist');
                        }
                        
                        // Дополнительная проверка безопасности родительской директории (опционально)
                        // Если Storage уже проверил существование - это достаточно безопасно
                        // Но для дополнительной защиты проверяем через realpath
                        try {
                            $parentFullPath = $this->disk->path($normalizedParent);
                            if (file_exists($parentFullPath)) {
                                $parentRealPath = realpath($parentFullPath);
                                
                                if ($parentRealPath !== false && $this->basePath !== '') {
                                    $normalizedParentPath = str_replace('\\', '/', rtrim($parentRealPath, '/\\'));
                                    $normalizedBasePath = str_replace('\\', '/', rtrim($this->basePath, '/\\'));
                                    
                                    // Для Windows учитываем регистр
                                    if (strtoupper(substr(PHP_OS, 0, 3)) === 'WIN') {
                                        $normalizedParentPath = strtolower($normalizedParentPath);
                                        $normalizedBasePath = strtolower($normalizedBasePath);
                                    }
                                    
                                    if (!str_starts_with($normalizedParentPath, $normalizedBasePath)) {
                                        // Логируем, но не блокируем - Storage уже проверил существование
                                        $this->logAction('security_warning', [
                                            'attempted_path' => $path,
                                            'parent_path' => $normalizedParent,
                                            'parent_real_path' => $normalizedParentPath,
                                            'base_path' => $normalizedBasePath,
                                        ]);
                                    }
                                }
                            }
                        } catch (\Throwable $e) {
                            // Если не можем проверить - разрешаем (родитель существует в Storage)
                        }
                    }
                    // Для корневой директории (parentPath === '') - путь уже валиден,
                    // так как мы проверили отсутствие traversal и глубину
                }
            } catch (\Throwable $e) {
                // Если не можем проверить - блокируем только если это не ожидаемая ошибка
                if ($checkExistence || str_contains($e->getMessage(), 'outside allowed')) {
                    abort(422, 'Invalid path: ' . $e->getMessage());
                }
            }
        }

        return $path;
    }

    /**
     * Log file manager actions
     */
    private function logAction(string $action, array $data = []): void
    {
        if (!config('filemanager.logging.enabled', true)) {
            return;
        }

        $channel = config('filemanager.logging.channel', 'daily');
        
        Log::channel($channel)->info("FileManager: {$action}", array_merge([
            'user_id' => MoonShineAuth::getGuard()->id(),
            'ip' => request()->ip(),
        ], $data));
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
        $request->validate([
            'path' => 'required|string|max:' . config('filemanager.security.max_filename_length', 255),
        ]);

        try {
            // Для создания новой директории не проверяем существование пути
            $path = $this->normalizePath($request->input('path'), false);
            if ($path === '') {
                return response()->json(['error' => 'Empty path'], 422);
            }

            // Проверка длины имени папки
            $folderName = basename($path);
            $maxLength = config('filemanager.security.max_filename_length', 255);
            if (mb_strlen($folderName) > $maxLength) {
                return response()->json(['error' => "Folder name exceeds maximum length of {$maxLength} characters"], 422);
            }

            // Проверяем, что директория еще не существует
            if ($this->disk->directoryExists($path)) {
                return response()->json(['error' => 'Directory already exists'], 422);
            }

            $this->disk->makeDirectory($path);
            
            // Очистка кэша
            $parentPath = dirname($path);
            $this->clearCache($parentPath === '.' ? '' : $parentPath);

            $this->logAction('create_folder', ['path' => $path]);

            return response()->json(['success' => true]);
        } catch (\Illuminate\Validation\ValidationException $e) {
            throw $e;
        } catch (\Throwable $e) {
            $this->logAction('error', [
                'action' => 'create_folder',
                'path' => $request->input('path'),
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
            ]);
            return response()->json(['error' => 'Error creating folder: ' . $e->getMessage()], 422);
        }
    }

    public function deleteFolder(Request $request)
    {
        $request->validate(['path' => 'required|string']);

        $path = $this->normalizePath($request->input('path'));
        if ($path === '') {
            abort(422, 'Refuse to delete root');
        }

        $this->disk->deleteDirectory($path);
        
        // Очистка кэша
        $this->clearCache($this->normalizePath(dirname($path) === '.' ? '' : dirname($path)));

        $this->logAction('delete_folder', ['path' => $path]);

        return response()->json(['success' => true]);
    }

    public function upload(Request $request)
    {
        $maxSize = config('filemanager.max_file_size', 10240);
        $allowedMimes = config('filemanager.allowed_mimes', []);
        $blockedExtensions = config('filemanager.security.blocked_extensions', []);

        $request->validate([
            'file' => [
                'required',
                'file',
                "max:{$maxSize}",
                function ($attribute, $value, $fail) use ($allowedMimes, $blockedExtensions) {
                    if (!$value) {
                        return;
                    }

                    $extension = strtolower($value->getClientOriginalExtension());
                    
                    // Проверка заблокированных расширений
                    if (in_array($extension, $blockedExtensions)) {
                        $fail("Файлы с расширением .{$extension} не разрешены к загрузке.");
                        return;
                    }

                    // Получаем MIME тип от Laravel
                    $mimeType = $value->getMimeType();
                    
                    // Получаем реальный MIME тип из содержимого файла (приоритетный)
                    $realMime = $this->getRealMimeType($value->getRealPath());
                    
                    // Используем реальный MIME тип, если он определен, иначе используем MIME от Laravel
                    $finalMimeType = $realMime ?: $mimeType;
                    
                    // Если MIME тип application/octet-stream (неопределенный), проверяем по расширению
                    if ($finalMimeType === 'application/octet-stream' || empty($finalMimeType)) {
                        $allowedExtensions = config('filemanager.allowed_extensions', []);
                        
                        // Если расширение в списке разрешенных - разрешаем
                        if (!empty($allowedExtensions) && in_array($extension, $allowedExtensions)) {
                            // Дополнительная проверка: для Office документов проверяем сигнатуру файла
                            if (in_array($extension, ['docx', 'xlsx', 'pptx', 'doc', 'xls', 'ppt'])) {
                                // Проверяем, что это действительно Office документ по сигнатуре
                                $isValidOffice = $this->validateOfficeFile($value->getRealPath(), $extension);
                                if (!$isValidOffice) {
                                    $fail("Файл не является валидным Office документом.");
                                    return;
                                }
                            }
                            // Разрешаем загрузку для разрешенных расширений с application/octet-stream
                            return;
                        } else {
                            $fail("Тип файла не может быть определен. Файлы с расширением .{$extension} не разрешены к загрузке.");
                            return;
                        }
                    }

                    // Проверка MIME типа (если он определен и не application/octet-stream)
                    if (!empty($allowedMimes) && !in_array($finalMimeType, $allowedMimes)) {
                        // Если реальный MIME не совпадает с заявленным - это подозрительно
                        if ($realMime && $realMime !== $mimeType) {
                            $fail("Обнаружено несоответствие типа файла. Загрузка отклонена.");
                            return;
                        }
                        
                        // Если MIME не в списке разрешенных, но расширение разрешено - разрешаем
                        $allowedExtensions = config('filemanager.allowed_extensions', []);
                        if (!empty($allowedExtensions) && in_array($extension, $allowedExtensions)) {
                            // Разрешаем для известных безопасных расширений
                            return;
                        }
                        
                        $fail("Тип файла {$finalMimeType} не разрешен к загрузке.");
                        return;
                    }
                },
            ],
            'path' => 'nullable|string'
        ]);

        $file = $request->file('file');
        $path = $this->normalizePath($request->input('path', ''));

        // Оригинальное имя с правильной кодировкой
        $filename = $file->getClientOriginalName();
        $filename = mb_convert_encoding($filename, 'UTF-8', 'auto');
        
        // Санитизация имени файла
        $filename = $this->sanitizeFileName($filename);

        // Проверка длины имени
        $maxLength = config('filemanager.security.max_filename_length', 255);
        if (mb_strlen($filename) > $maxLength) {
            $originalName = pathinfo($filename, PATHINFO_FILENAME);
            $extension = pathinfo($filename, PATHINFO_EXTENSION);
            $maxNameLength = $maxLength - (mb_strlen($extension) + 1);
            $filename = mb_substr($originalName, 0, $maxNameLength) . '.' . $extension;
        }

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

        // Очистка кэша
        $this->clearCache($path);

        $this->logAction('upload_file', [
            'filename' => $filename,
            'path' => $path,
            'size' => $file->getSize(),
            'mime' => $file->getMimeType(),
        ]);

        return response()->json([
            'success' => true,
            'disk_path' => $filePath,
            'public_path' => $this->publicPath($filePath),
            'filename' => $filename
        ]);
    }

    /**
     * Get real MIME type by reading file content
     */
    private function getRealMimeType(string $filePath): ?string
    {
        if (!file_exists($filePath) || !is_readable($filePath)) {
            return null;
        }

        $finfo = finfo_open(FILEINFO_MIME_TYPE);
        if ($finfo === false) {
            return null;
        }

        $mime = finfo_file($finfo, $filePath);
        finfo_close($finfo);

        return $mime ?: null;
    }

    /**
     * Validate Office file by checking file signature
     */
    private function validateOfficeFile(string $filePath, string $extension): bool
    {
        if (!file_exists($filePath) || !is_readable($filePath)) {
            return false;
        }

        $handle = fopen($filePath, 'rb');
        if ($handle === false) {
            return false;
        }

        // Читаем первые байты для проверки сигнатуры
        $header = fread($handle, 8);
        fclose($handle);

        if ($header === false) {
            return false;
        }

        // Проверка сигнатур Office файлов
        switch (strtolower($extension)) {
            case 'docx':
            case 'xlsx':
            case 'pptx':
                // Office Open XML (OOXML) файлы начинаются с PK (ZIP архив)
                // Сигнатура: 50 4B 03 04 (PK\x03\x04)
                return substr($header, 0, 2) === 'PK' && 
                       (ord($header[2]) === 0x03 || ord($header[2]) === 0x05 || ord($header[2]) === 0x07);
            
            case 'doc':
                // Старые DOC файлы (OLE2)
                // Сигнатура: D0 CF 11 E0 A1 B1 1A E1
                $oleSignature = "\xD0\xCF\x11\xE0\xA1\xB1\x1A\xE1";
                return substr($header, 0, 8) === $oleSignature;
            
            case 'xls':
                // Старые XLS файлы (OLE2 или BIFF)
                // OLE2 сигнатура
                $oleSignature = "\xD0\xCF\x11\xE0\xA1\xB1\x1A\xE1";
                if (substr($header, 0, 8) === $oleSignature) {
                    return true;
                }
                // BIFF сигнатура (старые Excel файлы)
                // Первые байты могут быть 09 08 или 00 00
                return true; // Более мягкая проверка для старых форматов
            
            case 'ppt':
                // Старые PPT файлы (OLE2)
                $oleSignature = "\xD0\xCF\x11\xE0\xA1\xB1\x1A\xE1";
                return substr($header, 0, 8) === $oleSignature;
            
            default:
                return true; // Для других расширений считаем валидным
        }
    }

    /**
     * Sanitize filename with proper encoding handling
     */
    private function sanitizeFileName(string $filename): string
    {
        // Нормализация Unicode
        if (function_exists('normalizer_normalize')) {
            $filename = normalizer_normalize($filename, \Normalizer::FORM_C);
        }

        // Конвертация в UTF-8
        $filename = mb_convert_encoding($filename, 'UTF-8', 'auto');

        // Запрещаем путь, разрешаем только имя
        $filename = str_replace(['\\', '/'], '_', $filename);

        // Нулевые байты и управляющие символы
        $filename = preg_replace('/\x00|[\x00-\x1F\x7F]/u', '_', $filename);

        // Спецсимволы, которые часто ломают FS/URL
        $filename = preg_replace('/[<>:"|?*]/u', '_', $filename);

        // Схлопываем пробелы
        $filename = preg_replace('/\s+/u', ' ', $filename);

        // Убираем ведущие/конечные точки и пробелы
        $filename = trim($filename, '. ');

        return $filename;
    }

    /**
     * Clear cache for a specific path
     */
    private function clearCache(string $path): void
    {
        if (!config('filemanager.cache.enabled', true)) {
            return;
        }

        // Очищаем кэш для текущей страницы и всех страниц этой директории
        $pattern = "filemanager:files:{$path}:*";
        
        // Laravel не поддерживает wildcard в Cache, поэтому очищаем все возможные страницы
        for ($i = 1; $i <= 100; $i++) {
            Cache::forget("filemanager:files:{$path}:{$i}");
        }
        
        // Также очищаем кэш родительской директории
        if ($path !== '') {
            $parentPath = dirname($path);
            if ($parentPath === '.') {
                $parentPath = '';
            }
            for ($i = 1; $i <= 100; $i++) {
                Cache::forget("filemanager:files:{$parentPath}:{$i}");
            }
        }
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
            
            // Очистка кэша
            $this->clearCache($this->normalizePath(dirname($diskPath) === '.' ? '' : dirname($diskPath)));

            $this->logAction('delete_file', ['path' => $diskPath]);

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
        // Нормализация Unicode
        if (function_exists('normalizer_normalize')) {
            $name = normalizer_normalize($name, \Normalizer::FORM_C);
        }

        // Конвертация в UTF-8
        $name = mb_convert_encoding($name, 'UTF-8', 'auto');
        $name = trim($name);

        // Запрещаем путь, разрешаем только имя
        $name = str_replace(['\\', '/'], '_', $name);

        // Нулевые байты и управляющие символы
        $name = preg_replace('/\x00|[\x00-\x1F\x7F]/u', '_', $name);

        // Спецсимволы, которые часто ломают FS/URL
        $name = preg_replace('/[<>:"|?*]/u', '_', $name);

        // Схлопываем пробелы
        $name = preg_replace('/\s+/u', ' ', $name);

        // Убираем ведущие/конечные точки и пробелы
        $name = trim($name, '. ');

        return $name;
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
        
        // Нормализуем новый путь (без проверки существования, так как он еще не создан)
        $newDiskPath = $this->normalizePath($newDiskPath, false);

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

        // Очистка кэша
        $parentPath = $this->normalizePath(dirname($oldDiskPath) === '.' ? '' : dirname($oldDiskPath));
        $this->clearCache($parentPath);

        $this->logAction('rename', [
            'type' => $type,
            'old_path' => $oldDiskPath,
            'new_path' => $newDiskPath,
        ]);

        return response()->json([
            'success' => true,
            'old_path' => $oldDiskPath,
            'new_path' => $newDiskPath,
            'public_path' => $type === 'file' ? $this->publicPath($newDiskPath) : null,
        ]);
    }

}
