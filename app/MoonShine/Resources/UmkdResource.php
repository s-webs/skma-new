<?php

declare(strict_types=1);

namespace App\MoonShine\Resources;

use Illuminate\Database\Eloquent\Model;
use App\Models\Umkd;

use MoonShine\Laravel\Resources\ModelResource;
use MoonShine\UI\Components\Layout\Box;
use MoonShine\UI\Fields\ID;
use MoonShine\Contracts\UI\FieldContract;
use MoonShine\Contracts\UI\ComponentContract;
use MoonShine\UI\Fields\Text;
use Sweet1s\MoonshineFileManager\FileManager;
use Sweet1s\MoonshineFileManager\FileManagerTypeEnum;

/**
 * @extends ModelResource<Umkd>
 */
class UmkdResource extends ModelResource
{
    protected string $model = Umkd::class;

    protected string $title = 'Umkds';

    /**
     * @return list<FieldContract>
     */
    protected function indexFields(): iterable
    {
        return [
            ID::make()->sortable(),
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
                Text::make('Название RU', 'name_ru'),
                Text::make('Название KZ', 'name_kz'),
                Text::make('Название EN', 'name_en'),
                FileManager::make('files')
                    ->typeOfFileManager(FileManagerTypeEnum::File)
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
     * @param Umkd $item
     *
     * @return array<string, string[]|string>
     * @see https://laravel.com/docs/validation#available-validation-rules
     */
    protected function rules(mixed $item): array
    {
        return [];
    }
}
