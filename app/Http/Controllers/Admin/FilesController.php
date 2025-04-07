<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use MoonShine\Laravel\MoonShineAuth;

class FilesController extends Controller
{
    private \Illuminate\Contracts\Filesystem\Filesystem $disk;
    private string $selectedDisk = 'uploads';
    private string $selectedDir = 'uploads';

    public function __construct()
    {
        if (!MoonShineAuth::getGuard()->check()) {
            abort(401);
        }

        $this->disk = Storage::disk($this->selectedDisk);
    }

    public function index()
    {
        return view('utils.filemanager');
    }

    public function files(Request $request)
    {
        $path = $request->query('path', '');
        $directories = $this->disk->directories($path);
        $files = [];

        foreach ($this->disk->files($path) as $file) {
            $files[] = [
                'name' => basename($file),
                'size' => $this->disk->size($file),
                'path' => $this->selectedDir . '/' . $file
            ];
        }

        return response()->json([
            'path' => $path,
            'directories' => $directories,
            'files' => $files
        ]);
    }

    public function createFolder(Request $request)
    {
        $request->validate(['path' => 'required|string']);

        $this->disk->makeDirectory($request->input('path'));
        return response()->json(['success' => true]);
    }

    public function deleteFolder(Request $request)
    {
        $request->validate(['path' => 'required|string']);

        $this->disk->deleteDirectory($request->input('path'));
        return response()->json(['success' => true]);
    }

    public function upload(Request $request)
    {
        $request->validate([
            'file' => 'required|file|max:10240',
            'path' => 'nullable|string'
        ]);

        $file = $request->file('file');
        $path = $request->input('path', '');

        // Получаем оригинальное имя файла
        $filename = $file->getClientOriginalName();

        // Убираем опасные символы, но сохраняем пробелы и кириллицу
        $filename = preg_replace([
            '/\//', // Слэши
            '/\x00/', // Null-байты
            '/[\x00-\x1F\x7F]/', // Управляющие символы
            '/[\/:\\|<>?*"]/' // Спецсимволы в именах файлов
        ], '_', $filename);

        // Обработка дубликатов
        $counter = 1;
        $originalName = pathinfo($filename, PATHINFO_FILENAME);
        $extension = pathinfo($filename, PATHINFO_EXTENSION);

        while ($this->disk->exists("$path/$filename")) {
            $filename = "{$originalName} ({$counter}).{$extension}";
            $counter++;
        }

        // Сохраняем файл
        $filePath = $file->storeAs(
            $path,
            $filename,
            $this->selectedDisk
        );

        return response()->json([
            'success' => true,
            'path' => $filePath,
            'filename' => $filename
        ]);
    }

    public function delete(Request $request)
    {
        $request->validate(['path' => 'required|string']);
        $path = $request->input('path');
        
        if (Storage::disk('public')->exists($path)) {
            Storage::disk('public')->delete($path);
            return response()->json(['success' => true]);
        }

        return response()->json(['error' => 'File not found'], 404);
    }

}
