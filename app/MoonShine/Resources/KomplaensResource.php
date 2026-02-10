<?php

declare(strict_types=1);

namespace App\MoonShine\Resources;

use Illuminate\Database\Eloquent\Model;
use App\Models\Komplaens;

use MoonShine\Laravel\Resources\ModelResource;
use MoonShine\UI\Components\Layout\Box;
use MoonShine\UI\Fields\ID;
use MoonShine\Contracts\UI\FieldContract;
use MoonShine\Contracts\UI\ComponentContract;
use MoonShine\UI\Components\Tabs;
use MoonShine\UI\Components\Tabs\Tab;
use MoonShine\UI\Fields\Position;
use MoonShine\UI\Fields\Select;
use MoonShine\UI\Fields\Text;
use MoonShine\UI\Fields\TextArea;
use MoonShine\UI\Fields\Image;
use MoonShine\UI\Fields\Json;
use MoonShine\UI\Fields\File;

/**
 * @extends ModelResource<Komplaens>
 */
class KomplaensResource extends ModelResource
{
    protected string $model = Komplaens::class;

    protected string $title = 'Komplaens';

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
                Tabs::make([
                    Tab::make('RU', [
                        Text::make('Название', 'title_ru'),
                        //TextArea::make('Описание', 'description_ru'),
                        Json::make('Карточки', 'cards_ru')
                            ->fields([
                                Position::make(),
                                Text::make('Название', 'title'),
                                Text::make('Подзаголовок', 'subtitle'),
                                Select::make('Опция', 'option')
                                    ->options([
                                        'link' => 'Ссылка',
                                        'file' => 'Файл',
                                    ]),
                                Text::make('Ссылка', 'link'),
                                File::make('Файл', 'file')
                                    ->dir('uploads/komplaens/ru/')
                                    ->keepOriginalFileName()
                                    ->removable(),
                            ])
                            ->vertical()
                            ->removable(),
                        File::make('documents_ru')
                            ->dir('uploads/komplaens/documents/ru')
                            ->keepOriginalFileName()
                            ->removable()
                            ->multiple()
                    ]),
                    Tab::make('KZ', [
                        Text::make('Название', 'title_kz'),
                        //TextArea::make('Описание', 'description_kz'),
                        Json::make('Карточки', 'cards_kz')
                            ->fields([
                                Position::make(),
                                Text::make('Название', 'title'),
                                Text::make('Подзаголовок', 'subtitle'),
                                Select::make('Опция', 'option')
                                    ->options([
                                        'link' => 'Ссылка',
                                        'file' => 'Файл',
                                    ]),
                                Text::make('Ссылка', 'link'),
                                File::make('Файл', 'file')
                                    ->dir('uploads/komplaens/kz/')
                                    ->keepOriginalFileName()
                                    ->removable(),
                            ])
                            ->vertical()
                            ->removable(),
                        File::make('documents_kz')
                            ->dir('uploads/komplaens/documents/kz')
                            ->keepOriginalFileName()
                            ->removable()
                            ->multiple()
                    ]),
                    Tab::make('EN', [
                        Text::make('Название', 'title_en'),
                        //TextArea::make('Описание', 'description_en'),
                        Json::make('Карточки', 'cards_en')
                            ->fields([
                                Position::make(),
                                Text::make('Название', 'title'),
                                Text::make('Подзаголовок', 'subtitle'),
                                Select::make('Опция', 'option')
                                    ->options([
                                        'link' => 'Ссылка',
                                        'file' => 'Файл',
                                    ]),
                                Text::make('Ссылка', 'link'),
                                File::make('Файл', 'file')
                                    ->dir('uploads/komplaens/en/')
                                    ->keepOriginalFileName()
                                    ->removable(),
                            ])
                            ->vertical()
                            ->removable(),
                        File::make('documents_en')
                            ->dir('uploads/komplaens/documents/en')
                            ->keepOriginalFileName()
                            ->removable()
                            ->multiple()
                    ]),
                    Tab::make('Фотографии', [
                        Image::make('Фотографии', 'images')
                            ->multiple()
                            ->dir('uploads/komplaens/images')
                            ->removable(),
                        Image::make('Фото', 'photo')
                            ->dir('uploads/komplaens/images')
                            ->customName(function ($file, $field) {
                                $timestamp = now()->format('Y_m_d_His');
                                return 'image_' . $timestamp . "_RU_." . $file->extension();
                            })
                            ->removable(),
                        Image::make('Изображение для страницы', 'page_preview')
                            ->dir('uploads/komplaens/images')
                            ->customName(function ($file, $field) {
                                $timestamp = now()->format('Y_m_d_His');
                                return 'image_' . $timestamp . "_RU_." . $file->extension();
                            })
                            ->removable(),
                    ])
                ]),
            ]),
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
     * @param Komplaens $item
     *
     * @return array<string, string[]|string>
     * @see https://laravel.com/docs/validation#available-validation-rules
     */
    protected function rules(mixed $item): array
    {
        return [];
    }
}
