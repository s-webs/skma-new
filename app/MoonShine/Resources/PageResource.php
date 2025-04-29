<?php

declare(strict_types=1);

namespace App\MoonShine\Resources;

use Illuminate\Database\Eloquent\Model;
use App\Models\Page;

use MoonShine\Laravel\Fields\Relationships\BelongsTo;
use MoonShine\Laravel\Fields\Slug;
use MoonShine\Laravel\Resources\ModelResource;
use MoonShine\TinyMce\Fields\TinyMce;
use MoonShine\UI\Components\Layout\Box;
use MoonShine\UI\Components\Tabs;
use MoonShine\UI\Components\Tabs\Tab;
use MoonShine\UI\Fields\ID;
use MoonShine\Contracts\UI\FieldContract;
use MoonShine\Contracts\UI\ComponentContract;
use MoonShine\UI\Fields\Text;

/**
 * @extends ModelResource<Page>
 */
class PageResource extends ModelResource
{
    protected string $model = Page::class;

    protected string $title = 'Pages';

    /**
     * @return list<FieldContract>
     */
    protected function indexFields(): iterable
    {
        return [
            ID::make()->sortable(),
            Text::make('Название', 'name_ru')
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
                BelongsTo::make('Подразделение', 'division', 'name_ru', resource: DivisionResource::class),
                Tabs::make([
                    Tab::make('RU', [
                        Text::make('Название на русском', 'name_ru'),
                        TinyMce::make('Описание на русском', 'description_ru'),
                        Slug::make('SLUG RU', 'slug_ru')->from('name_ru'),
                    ]),
                    Tab::make('KZ', [
                        Text::make('Название на казахском', 'name_kz'),
                        TinyMce::make('Описание на казахском', 'description_kz'),
                        Slug::make('SLUG KZ', 'slug_kz')->from('name_kz'),
                    ]),
                    Tab::make('EN', [
                        Text::make('Название на английском', 'name_en'),
                        TinyMce::make('Описание на английском', 'description_en'),
                        Slug::make('SLUG EN', 'slug_en')->from('name_en'),
                    ]),
                ]),
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
     * @param Page $item
     *
     * @return array<string, string[]|string>
     * @see https://laravel.com/docs/validation#available-validation-rules
     */
    protected function rules(mixed $item): array
    {
        return [];
    }
}
