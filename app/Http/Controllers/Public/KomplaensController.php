<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use App\Models\Komplaens;
use Illuminate\Http\Request;

class KomplaensController extends Controller
{
    public function show()
    {
        $item = Komplaens::query()->first();

        // Получаем оригинальный массив документов
        $documents = $item->getProperty('documents');

        // Массив для обработанных документов
        $processedDocuments = [];

        // Обрабатываем каждый документ: разбиваем строку пути на 'path' и 'filename'
        foreach (json_decode($documents) as $document) {
            $info = pathinfo($document);
            $processedDocuments[] = [
                'path' => $info['dirname'] . '/' . $info['basename'],
                'filename' => $info['basename'], // или можно использовать 'filename' для имени без расширения
            ];
        }

        // Добавляем обработанный массив к объекту $item, например, как новое свойство
        $item->documents_processed = $processedDocuments;

        // Передаем $item с обработанными данными во view
        return view('pages.komplaens.show', compact('item'));
    }

}
