<?php

declare(strict_types=1);

namespace App\MoonShine\Resources;

use App\Models\Department;
use Illuminate\Database\Eloquent\Model;
use App\Models\News;

use MoonShine\ImportExport\Contracts\HasImportExportContract;
use MoonShine\ImportExport\Traits\ImportExportConcern;
use MoonShine\Laravel\Fields\Slug;
use MoonShine\Laravel\Resources\ModelResource;
use MoonShine\Support\Enums\PageType;
use MoonShine\TinyMce\Fields\TinyMce;
use MoonShine\UI\Components\Layout\Box;
use MoonShine\UI\Components\Layout\Divider;
use MoonShine\UI\Components\Tabs;
use MoonShine\UI\Components\Tabs\Tab;
use MoonShine\UI\Fields\Date;
use MoonShine\UI\Fields\DateRange;
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
class NewsResource extends ModelResource implements HasImportExportContract
{
    use ImportExportConcern;

    protected string $model = News::class;

    protected string $title = 'Новости';

    protected ?PageType $redirectAfterSave = PageType::INDEX;

    protected function search(): array
    {
        return ['id', 'title_ru', 'title_kz', 'title_en'];
    }

    /**
     * @return list<FieldContract>
     */
    protected function indexFields(): iterable
    {
        return [
            ID::make()->sortable(),
            Image::make('Превью', 'preview_ru'),
            Text::make('Заголовок', 'title_ru'),
//            Switcher::make('Опубликовано', 'is_published')
            Date::make('Дата', 'created_at')
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
                        TinyMce::make('Содержание', 'text_ru')
                            ->addOption('file_manager', 'laravel-filemanager'),
                        Slug::make('Slug', 'slug_ru')->unique()->from('title_ru'),
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
                        TinyMce::make('Содержание', 'text_kz')
                            ->addOption('file_manager', 'laravel-filemanager'),
                        Slug::make('Slug', 'slug_kz')->unique()->from('title_kz'),
                        Image::make('Превью', 'preview_kz')
                            ->dir('uploads/news/')
                            ->customName(function ($file, $field) {
                                $timestamp = now()->format('Y_m_d_His');
                                return 'news_' . $timestamp . "_KZ_." . $file->extension();
                            })
                            ->removable(),
                    ]),
                    Tab::make('EN', [
                        Text::make('Название на английском', 'title_en'),
                        TinyMce::make('Содержание', 'text_en')
                            ->addOption('file_manager', 'laravel-filemanager'),
                        Slug::make('Slug', 'slug_en')->unique()->from('title_en'),
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
                Image::make('Изображения', 'images')
                    ->dir('uploads/news/sliders')
                    ->removable()
                    ->multiple(),
                Switcher::make('Активно', 'published')->default(false),

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

    protected function exportFields(): iterable
    {
        return [
            ID::make(),
            Text::make('Заголовок', 'title_kz'),
            Date::make('Дата', 'created_at'),
        ];
    }

    protected function filters(): iterable
    {
        return [
            DateRange::make('Дата', 'created_at')
                ->format('d.m.Y')
        ];
    }
}
