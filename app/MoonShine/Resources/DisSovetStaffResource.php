<?php

declare(strict_types=1);

namespace App\MoonShine\Resources;

use Illuminate\Database\Eloquent\Model;
use App\Models\DisSovetStaff;

use MoonShine\Laravel\Resources\ModelResource;
use MoonShine\TinyMce\Fields\TinyMce;
use MoonShine\UI\Components\Layout\Box;
use MoonShine\UI\Components\Tabs;
use MoonShine\UI\Components\Tabs\Tab;
use MoonShine\UI\Fields\File;
use MoonShine\UI\Fields\ID;
use MoonShine\Contracts\UI\FieldContract;
use MoonShine\Contracts\UI\ComponentContract;
use MoonShine\UI\Fields\Text;

/**
 * @extends ModelResource<DisSovetStaff>
 */
class DisSovetStaffResource extends ModelResource
{
    protected string $model = DisSovetStaff::class;

    protected string $title = 'DisSovetStaffs';

    /**
     * @return list<FieldContract>
     */
    protected function indexFields(): iterable
    {
        return [
            ID::make()->sortable(),
            Text::make('Название RU', 'title_ru'),
            Text::make('Название KZ', 'title_kz'),
            Text::make('Название EN', 'title_en'),
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
                    Tab::make('RU', [
                        Text::make('Название', 'title_ru')->unescape(),
                        TinyMce::make('Контент', 'description_ru'),
                        File::make('Файл', 'file_ru')
                            ->dir('uploads/dis-sovet/staff')
                            ->keepOriginalFileName()
                            ->sortable()
                            ->multiple()
							->removable()
							->sortable()
                    ]),
                    Tab::make('KZ', [
                        Text::make('Название', 'title_kz')->unescape(),
                        TinyMce::make('Контент', 'description_kz'),
                        File::make('Файл', 'file_kz')
                            ->dir('uploads/dis-sovet/staff')
                            ->keepOriginalFileName()
                            ->sortable()
                            ->multiple()
							->removable()
							->sortable()
                    ]),
                    Tab::make('EN', [
                        Text::make('Название', 'title_en')->unescape(),
                        TinyMce::make('Контент', 'description_en'),
                        File::make('Файл', 'file_en')
                            ->dir('uploads/dis-sovet/staff')
                            ->keepOriginalFileName()
                            ->sortable()
                            ->multiple()
							->removable()
							->sortable()
                    ]),
                ])
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
     * @param DisSovetStaff $item
     *
     * @return array<string, string[]|string>
     * @see https://laravel.com/docs/validation#available-validation-rules
     */
    protected function rules(mixed $item): array
    {
        return [];
    }
}
