<?php

namespace App\Http\Controllers;

use App\Models\News;
use App\Models\Page;
use Illuminate\Http\Request;

class LocalizedController extends Controller
{
    public function handle($locale, $entity, $slug)
    {
        $model = $this->resolveModel($entity); // Определяем модель

        if (!$model) {
            abort(404); // Если модель не найдена
        }

        // Определяем поле slug для текущего языка
        $slugField = 'slug_' . $locale;

        // Поиск записи
        $item = $model::where($slugField, $slug)->firstOrFail();

        // Возвращаем соответствующий вид
        return view("{$entity}.show", compact('item'));
    }

    /**
     * Определяет модель на основе сущности.
     */
    protected function resolveModel($entity)
    {
        return match ($entity) {
            'news' => News::class,
            'pages' => Page::class,
            default => null,
        };
    }
}
