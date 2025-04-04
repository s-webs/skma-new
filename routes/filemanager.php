<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Route;

Route::get('/fmanager', function () {
    return view('utils.filemanager');
});

Route::get('/files', function (Request $request) {
    $path = $request->query('path', '');
    $directories = Storage::disk('public')->directories($path);
    $files = [];

    foreach (Storage::disk('public')->files($path) as $file) {
        $files[] = [
            'name' => basename($file),
            'size' => Storage::disk('public')->size($file), // Получаем размер файла
            'path' => $file
        ];
    }

    return response()->json([
        'path' => $path,
        'directories' => $directories,
        'files' => $files
    ]);
});

Route::post('/files/upload', function (Request $request) {
    $request->validate([
        'file' => 'required|file|max:10240',
        'path' => 'nullable|string'
    ]);

    $path = $request->input('path', '');
    $filePath = $request->file('file')->store($path, 'public');

    return response()->json(['path' => $filePath]);
});

Route::post('/files/create-folder', function (Request $request) {
    $request->validate(['path' => 'required|string']);

    Storage::disk('public')->makeDirectory($request->input('path'));
    return response()->json(['success' => true]);
});

Route::post('/files/delete', function (Request $request) {
    $request->validate(['path' => 'required|string']);

    $path = $request->input('path');
    if (Storage::disk('public')->exists($path)) {
        Storage::disk('public')->delete($path);
        return response()->json(['success' => true]);
    }

    return response()->json(['error' => 'File not found'], 404);
});

Route::post('/files/delete-folder', function (Request $request) {
    $request->validate(['path' => 'required|string']);

    Storage::disk('public')->deleteDirectory($request->input('path'));
    return response()->json(['success' => true]);
});
