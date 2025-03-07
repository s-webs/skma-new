<?php

declare(strict_types=1);

namespace App\MoonShine\Resources;

use App\Models\Department;
use Illuminate\Database\Eloquent\Model;
use App\Models\News;

use MoonShine\Laravel\Fields\Slug;
use MoonShine\Laravel\Resources\ModelResource;
use MoonShine\Support\Enums\PageType;
use MoonShine\TinyMce\Fields\TinyMce;
use MoonShine\UI\Components\Layout\Box;
use MoonShine\UI\Components\Layout\Divider;
use MoonShine\UI\Components\Tabs;
use MoonShine\UI\Components\Tabs\Tab;
use MoonShine\UI\Fields\ID;
use MoonShine\Contracts\UI\FieldContract;
use MoonShine\Contracts\UI\ComponentContract;
use MoonShine\UI\Fields\Image;
use MoonShine\UI\Fields\Select;
use MoonShine\UI\Fields\Switcher;
use MoonShine\UI\Fields\Text;

/**
 * @extends ModelResource<News>
 */
class NewsResource extends ModelResource
{
    protected string $model = News::class;

    protected string $title = 'Новости';

    protected ?PageType $redirectAfterSave = PageType::INDEX;

    /**
     * @return list<FieldContract>
     */
    protected function indexFields(): iterable
    {
        return [
            ID::make()->sortable(),
            Image::make('Превью', 'preview_ru'),
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
                Select::make('Кафедра / Подразделение', 'department')
                    ->options([
                        'Кафедры' => Department::query()->get()->pluck('name_ru', 'id')->toArray(),
                        'Подразделения' => [],
                    ])
                    ->nullable()
                    ->reactive()
                    ->searchable(),
                Divider::make(),
                Tabs::make([
                    Tab::make('RU', [
                        Text::make('Название на русском', 'title_ru'),
                        TinyMce::make('Содержание', 'text_ru'),
                        Slug::make('Slug', 'slug_ru')->from('title_ru'),
                        Image::make('Превью', 'preview_ru')
                            ->dir('uploads/news/')
                            ->customName(function ($file, $field) {
                                $timestamp = now()->format('Y_m_d_His');
                                return 'news_' . $timestamp . "_RU_." . $file->extension();
                            })
                            ->removable(),
                    ]),
                    Tab::make('KZ', [
                        Text::make('Название на казахском', 'title_kz'),
                        TinyMce::make('Содержание', 'text_kz'),
                        Slug::make('Slug', 'slug_kz')->from('title_kz'),
                        Image::make('Превью', 'preview_kz')
                            ->dir('uploads/news/')
                            ->customName(function ($file, $field) {
                                $timestamp = now()->format('Y_m_d_His');
                                return 'news_' . $timestamp . "_KZ_." . $file->extension();
                            })
                            ->removable(),
                    ]),
                    Tab::make('EN', [
                        Text::make('Название на ангдийском', 'title_en'),
                        TinyMce::make('Содержание', 'text_en'),
                        Slug::make('Slug', 'slug_en')->from('title_en'),
                        Image::make('Превью', 'preview_en')
                            ->dir('uploads/news/')
                            ->customName(function ($file, $field) {
                                $timestamp = now()->format('Y_m_d_His');
                                return 'news_' . $timestamp . "_EN_." . $file->extension();
                            })
                            ->removable(),
                    ]),
                ]),
                Divider::make(),
                Switcher::make('Активно', 'is_published'),

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
     * @param News $item
     *
     * @return array<string, string[]|string>
     * @see https://laravel.com/docs/validation#available-validation-rules
     */
    protected function rules(mixed $item): array
    {
        return [];
    }
}
