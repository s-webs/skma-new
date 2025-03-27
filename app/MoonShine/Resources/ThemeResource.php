<?php

declare(strict_types=1);

namespace App\MoonShine\Resources;

use Illuminate\Database\Eloquent\Model;
use App\Models\Theme;

use MoonShine\Laravel\Resources\ModelResource;
use MoonShine\UI\Components\Collapse;
use MoonShine\UI\Components\Layout\Box;
use MoonShine\UI\Components\Layout\Divider;
use MoonShine\UI\Fields\Color;
use MoonShine\UI\Fields\ID;
use MoonShine\Contracts\UI\FieldContract;
use MoonShine\Contracts\UI\ComponentContract;
use MoonShine\UI\Fields\Image;
use MoonShine\UI\Fields\Switcher;
use MoonShine\UI\Fields\Text;
use Spatie\ImageOptimizer\OptimizerChainFactory;

/**
 * @extends ModelResource<Theme>
 */
class ThemeResource extends ModelResource
{
    protected string $model = Theme::class;

    protected string $title = 'Темы';

    /**
     * @return list<FieldContract>
     */
    protected function indexFields(): iterable
    {
        return [
            ID::make()->sortable(),
            Image::make('Скриншот', 'image'),
            Text::make('Название', 'name'),
            Text::make('Код темы', 'code'),
            Switcher::make('Активно', 'active')
        ];
    }

    /**
     * @return list<ComponentContract|FieldContract>
     */
    protected function formFields(): iterable
    {
        return [
            Box::make([
                ID::make(),
                Text::make('Название', 'name'),
                Image::make('Скриншот', 'image')
                    ->dir('uploads/themes/')
                    ->customName(function ($file, $field) {
                        $timestamp = now()->format('Y_m_d_His');
                        return 'theme_' . $timestamp . "." . $file->extension();
                    })
                    ->removable(),
                Text::make('Код темы', 'code'),
                Collapse::make('Цвета', [
                    Color::make('Dark'),
                    Color::make('Halftone'),
                    Color::make('Main'),
                    Color::make('Secondary'),
                    Color::make('Primary'),
                    Color::make('Heading'),
                    Color::make('Extra'),
                ]),
                Image::make('Паттерн 01', 'pattern_01')
                    ->dir('uploads/themes/patterns/')
                    ->customName(function ($file, $field) {
                        $timestamp = now()->format('Y_m_d_His');
                        return 'pattern_01_' . $timestamp . "." . $file->extension();
                    })
                    ->removable(),
                Image::make('Паттерн 02', 'pattern_02')
                    ->dir('uploads/themes/patterns/')
                    ->customName(function ($file, $field) {
                        $timestamp = now()->format('Y_m_d_His');
                        return 'pattern_02_' . $timestamp . "." . $file->extension();
                    })
                    ->removable(),
                Divider::make(),
                Switcher::make('Активно', 'active')
            ])
        ];
    }

    /**
     * @return list<FieldContract>
     */
    protected function detailFields(): iterable
    {
        return [
            ID::make(),
        ];
    }

    /**
     * @param Theme $item
     *
     * @return array<string, string[]|string>
     * @see https://laravel.com/docs/validation#available-validation-rules
     */
    protected function rules(mixed $item): array
    {
        return [];
    }
}
