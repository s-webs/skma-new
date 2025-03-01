<?php

declare(strict_types=1);

namespace App\MoonShine\Resources;

use Illuminate\Database\Eloquent\Model;
use App\Models\Announce;

use MoonShine\Laravel\Resources\ModelResource;
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
use MoonShine\UI\Fields\Textarea;

/**
 * @extends ModelResource<Announce>
 */
class AnnounceResource extends ModelResource
{
    protected string $model = Announce::class;

    protected string $title = 'Анонсы';

    /**
     * @return list<FieldContract>
     */
    protected function indexFields(): iterable
    {
        return [
            ID::make()->sortable(),
            Image::make('Изображение', 'image_ru'),
            Text::make('Заголовок', 'title_ru'),
            Switcher::make('Опубликовано', 'is_published')
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
                        Text::make('Заголовок', 'title_ru')->required(),
                        Textarea::make('Описание', 'description_ru'),
                        Text::make('Ссылка', 'link_ru'),
                        Image::make('Изображение', 'image_ru')
                            ->dir('uploads/announces/')
                            ->customName(function ($file, $field) {
                                $timestamp = now()->format('Y_m_d_His');
                                return 'announce_' . $timestamp . "_ru_." . $file->extension();
                            })
                            ->removable(),
                    ]),
                    Tab::make('KZ', [
                        Text::make('Заголовок', 'title_kz')->required(),
                        Textarea::make('Описание', 'description_kz'),
                        Text::make('Ссылка', 'link_kz'),
                        Image::make('Изображение', 'image_kz')
                            ->dir('uploads/announces/')
                            ->customName(function ($file, $field) {
                                $timestamp = now()->format('Y_m_d_His');
                                return 'announce_' . $timestamp . "_kz_." . $file->extension();
                            })
                            ->removable(),
                    ]),
                    Tab::make('EN', [
                        Text::make('Заголовок', 'title_en')->required(),
                        Textarea::make('Описание', 'description_en'),
                        Text::make('Ссылка', 'link_en'),
                        Image::make('Изображение', 'image_en')
                            ->dir('uploads/announces/')
                            ->customName(function ($file, $field) {
                                $timestamp = now()->format('Y_m_d_His');
                                return 'announce_' . $timestamp . "_en_." . $file->extension();
                            })
                            ->removable(),
                    ]),
                ]),
                Divider::make(),
                Switcher::make('Опубликовано', 'is_published')->default(false)
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
     * @param Announce $item
     *
     * @return array<string, string[]|string>
     * @see https://laravel.com/docs/validation#available-validation-rules
     */
    protected function rules(mixed $item): array
    {
        return [];
    }
}
