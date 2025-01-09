<?php

declare(strict_types=1);

namespace App\MoonShine\Resources;

use App\Models\Counter;

use MoonShine\Laravel\Resources\ModelResource;
use MoonShine\UI\Components\Layout\Box;
use MoonShine\UI\Components\Link;
use MoonShine\UI\Components\Tabs;
use MoonShine\UI\Components\Tabs\Tab;
use MoonShine\UI\Fields\ID;
use MoonShine\Contracts\UI\FieldContract;
use MoonShine\Contracts\UI\ComponentContract;
use MoonShine\UI\Fields\Number;
use MoonShine\UI\Fields\Switcher;
use MoonShine\UI\Fields\Text;
use MoonShine\UI\Fields\Url;

/**
 * @extends ModelResource<Counter>
 */
class CounterResource extends ModelResource
{
    protected string $model = Counter::class;

    protected string $title = 'Счетчики';

    /**
     * @return list<FieldContract>
     */
    protected function indexFields(): iterable
    {
        return [
            ID::make()->sortable(),
            Text::make('Название на русском', 'name_ru'),
//            Url::make('Ссылка на русском', 'link_ru'),
            Text::make('Название на казахском', 'name_kz'),
//            Url::make('Ссылка на казахском', 'link_kz'),
            Text::make('Название на английском', 'name_en'),
//            Url::make('Ссылка на английском', 'link_en'),
//            Switcher::make('Внешняя ссылка', 'link_external')
            Number::make('Счетчик', 'count')
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
                        Text::make('Название', 'name_ru')
                            ->required(),
                        Url::make('Ссылка (если есть)', 'link_ru'),
                    ]),
                    Tab::make('KZ', [
                        Text::make('Название', 'name_kz')
                            ->required(),
                        Url::make('Ссылка (если есть)', 'link_kz'),
                    ]),
                    Tab::make('EN', [
                        Text::make('Название', 'name_en')
                            ->required(),
                        Url::make('Ссылка (если есть)', 'link_en'),
                    ])
                ]),
                Number::make('Счетчик', 'count')->default(0),
                Switcher::make('Внешняя ссылка', 'link_external')
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
     * @param Counter $item
     *
     * @return array<string, string[]|string>
     * @see https://laravel.com/docs/validation#available-validation-rules
     */
    protected function rules(mixed $item): array
    {
        return [];
    }
}
