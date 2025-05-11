<?php

declare(strict_types=1);

namespace App\MoonShine\Resources;

use Illuminate\Database\Eloquent\Model;
use App\Models\CmsPage;

use MoonShine\Laravel\Fields\Slug;
use MoonShine\Laravel\Resources\ModelResource;
use MoonShine\TinyMce\Fields\TinyMce;
use MoonShine\UI\Components\Layout\Box;
use MoonShine\UI\Components\Layout\Divider;
use MoonShine\UI\Components\Tabs;
use MoonShine\UI\Components\Tabs\Tab;
use MoonShine\UI\Fields\ID;
use MoonShine\Contracts\UI\FieldContract;
use MoonShine\Contracts\UI\ComponentContract;
use MoonShine\UI\Fields\Image;
use MoonShine\UI\Fields\Switcher;
use MoonShine\UI\Fields\Text;

/**
 * @extends ModelResource<CmsPage>
 */
class CmsPageResource extends ModelResource
{
    protected string $model = CmsPage::class;

    protected string $title = 'CmsPages';

    /**
     * @return list<FieldContract>
     */
    protected function indexFields(): iterable
    {
        return [
            ID::make()->sortable(),
            Text::make('Название', 'name_ru'),
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
                        Text::make('Название на русском', 'name_ru'),
                        TinyMce::make('Содержание', 'text_ru')
                            ->addOption('file_manager', 'laravel-filemanager'),
                        Slug::make('Slug', 'slug_ru')->from('name_ru'),
                    ]),
                    Tab::make('KZ', [
                        Text::make('Название на казахском', 'name_kz'),
                        TinyMce::make('Содержание', 'text_kz')
                            ->addOption('file_manager', 'laravel-filemanager'),
                        Slug::make('Slug', 'slug_kz')->from('name_kz'),
                    ]),
                    Tab::make('EN', [
                        Text::make('Название на английском', 'name_en'),
                        TinyMce::make('Содержание', 'text_en')
                            ->addOption('file_manager', 'laravel-filemanager'),
                        Slug::make('Slug', 'slug_en')->from('name_en'),
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
     * @param CmsPage $item
     *
     * @return array<string, string[]|string>
     * @see https://laravel.com/docs/validation#available-validation-rules
     */
    protected function rules(mixed $item): array
    {
        return [];
    }
}
