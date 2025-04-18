<?php

declare(strict_types=1);

namespace App\MoonShine\Resources;

use Illuminate\Database\Eloquent\Model;
use App\Models\Graduate;

use MoonShine\ImportExport\Contracts\HasImportExportContract;
use MoonShine\ImportExport\Traits\ImportExportConcern;
use MoonShine\Laravel\Resources\ModelResource;
use MoonShine\Support\Enums\Color;
use MoonShine\UI\Components\Layout\Box;
use MoonShine\UI\Components\Layout\Divider;
use MoonShine\UI\Components\Tabs;
use MoonShine\UI\Components\Tabs\Tab;
use MoonShine\UI\Fields\ID;
use MoonShine\Contracts\UI\FieldContract;
use MoonShine\Contracts\UI\ComponentContract;
use MoonShine\UI\Fields\Image;
use MoonShine\UI\Fields\Number;
use MoonShine\UI\Fields\Text;
use MoonShine\UI\Fields\Textarea;

/**
 * @extends ModelResource<Graduate>
 */
class GraduateResource extends ModelResource implements HasImportExportContract
{
    use ImportExportConcern;

    protected string $model = Graduate::class;

    protected string $title = 'Graduates';

    /**
     * @return list<FieldContract>
     */
    protected function indexFields(): iterable
    {
        return [
            ID::make()->sortable(),
            Text::make('Факультет', 'faculty_ru')
            ->badge(Color::GREEN),
            Text::make('Имя', 'name')->sortable(),
            Text::make('Имя на латинском', 'name_latin')->sortable(),
            Number::make('Год', 'year')->sortable(),
            Textarea::make('Описание', 'description_ru')->sortable(),
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
                Tabs::make([
                    Tab::make('Основная информация', [
                        Text::make('Имя', 'name')->required(),
                        Text::make('Имя на латинском', 'name_latin')->required(),
                        Number::make('Год', 'year')->required(),
                        Text::make('Факультет на русском', 'faculty_ru')->required(),
                        Text::make('Факультет на казахском', 'faculty_kz')->required(),
                        Text::make('Факультет на английском', 'faculty_en')->required(),
                        Text::make('Формат обучения', 'format')->required(),
                        Text::make('Тип диплома', 'diplom_type')->required(),
                    ]),
                    Tab::make('Необязательные поля', [
                        Image::make('Фотография (необязательно)', 'photo'),
                        Textarea::make('Описание на русском', 'description_ru'),
                        Textarea::make('Описание на казахском', 'description_kz'),
                        Textarea::make('Описание на английском', 'description_en'),
                        Textarea::make('Отзыв (необязательно)', 'review'),
                        Text::make('Язык отзыва', 'language'),
                    ])
                ]),
            ])
        ];
    }

    protected function importFields(): iterable
    {
        return [
            ID::make(),
            Text::make('Имя', 'name')->required(),
            Text::make('Имя на латинском', 'name_latin'),
            Number::make('Год', 'year')->required(),
            Text::make('Формат обучения', 'format'),
            Text::make('Тип диплома', 'diplom_type'),
            Text::make('Факультет на русском', 'faculty_ru'),
            Text::make('Факультет на казахском', 'faculty_kz'),
            Text::make('Факультет на английском', 'faculty_en'),
        ];
    }

    protected function exportFields(): iterable
    {
        return [
            ID::make(),
            Text::make('Имя', 'name')->required(),
            Text::make('Имя на латинском', 'name_latin'),
            Number::make('Год', 'year')->required(),
            Text::make('Формат обучения', 'format'),
            Text::make('Тип диплома', 'diplom_type'),
            Text::make('Факультет на русском', 'faculty_ru'),
            Text::make('Факультет на казахском', 'faculty_kz'),
            Text::make('Факультет на английском', 'faculty_en'),
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
     * @param Graduate $item
     *
     * @return array<string, string[]|string>
     * @see https://laravel.com/docs/validation#available-validation-rules
     */
    protected function rules(mixed $item): array
    {
        return [];
    }
}
