<?php

declare(strict_types=1);

namespace App\MoonShine\Resources;

use Illuminate\Database\Eloquent\Model;
use App\Models\Graduate;

use MoonShine\ImportExport\Contracts\HasImportExportContract;
use MoonShine\ImportExport\Traits\ImportExportConcern;
use MoonShine\Laravel\Resources\ModelResource;
use MoonShine\UI\Components\Layout\Box;
use MoonShine\UI\Components\Layout\Divider;
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
            Text::make('Имя', 'name')->sortable(),
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
                Image::make('Фотография (необязательно)', 'photo'),
                Divider::make(),
                Text::make('Имя', 'name')->required(),
                Text::make('Имя на латинском', 'name_latin'),
                Number::make('Год', 'year')->required(),
                Textarea::make('Описание на русском', 'description_ru'),
                Textarea::make('Описание на казахском', 'description_kz'),
                Textarea::make('Описание на английском', 'description_en'),
            ])
        ];
    }

    protected function exportFields(): iterable
    {
        return [
            ID::make(),
            Text::make('Имя', 'name')->required(),
            Text::make('Имя на латинском', 'name_latin'),
            Number::make('Год', 'year')->required(),
            Textarea::make('Описание на русском', 'description_ru'),
            Textarea::make('Описание на казахском', 'description_kz'),
            Textarea::make('Описание на английском', 'description_en'),
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
