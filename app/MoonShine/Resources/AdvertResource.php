<?php

declare(strict_types=1);

namespace App\MoonShine\Resources;

use Illuminate\Database\Eloquent\Model;
use App\Models\Advert;

use MoonShine\Laravel\Fields\Slug;
use MoonShine\Laravel\Resources\ModelResource;
use MoonShine\TinyMce\Fields\TinyMce;
use MoonShine\UI\Components\Layout\Box;
use MoonShine\UI\Components\Tabs;
use MoonShine\UI\Components\Tabs\Tab;
use MoonShine\UI\Fields\Date;
use MoonShine\UI\Fields\ID;
use MoonShine\Contracts\UI\FieldContract;
use MoonShine\Contracts\UI\ComponentContract;
use MoonShine\UI\Fields\Switcher;
use MoonShine\UI\Fields\Text;

/**
 * @extends ModelResource<Advert>
 */
class AdvertResource extends ModelResource
{
    protected string $model = Advert::class;

    protected string $title = 'Adverts';

    /**
     * @return list<FieldContract>
     */
    protected function indexFields(): iterable
    {
        return [
            ID::make()->sortable(),
            Text::make('Название', 'title_ru'),
            Date::make('Дата', 'created_at'),
            Switcher::make('Активно', 'is_published')->default(false),
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
                        Text::make('Название', 'title_ru'),
                        TinyMce::make('Контент', 'description_ru')
							->addOption('file_manager', 'laravel-filemanager'),
                        Slug::make('Slug', 'slug_ru')
                            ->from('title_ru'),
                    ]),
                    Tab::make('KZ', [
                        Text::make('Название', 'title_kz'),
                        TinyMce::make('Контент', 'description_kz')
							->addOption('file_manager', 'laravel-filemanager'),
                        Slug::make('Slug', 'slug_kz')
                            ->from('title_kz'),
                    ]),
                    Tab::make('EN', [
                        Text::make('Название', 'title_en'),
                        TinyMce::make('Контент', 'description_en')
							->addOption('file_manager', 'laravel-filemanager'),
                        Slug::make('Slug', 'slug_en')
                            ->from('title_en'),
                    ]),
                ]),
                Date::make('Дата', 'created_at'),
                Switcher::make('Активно', 'is_published')->default(false),
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
     * @param Advert $item
     *
     * @return array<string, string[]|string>
     * @see https://laravel.com/docs/validation#available-validation-rules
     */
    protected function rules(mixed $item): array
    {
        return [];
    }
}
