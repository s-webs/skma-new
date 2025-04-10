<?php

declare(strict_types=1);

namespace App\MoonShine\Resources;

use Illuminate\Database\Eloquent\Model;
use App\Models\Faculty;

use MoonShine\Laravel\Fields\Relationships\BelongsTo;
use MoonShine\Laravel\Fields\Relationships\HasMany;
use MoonShine\Laravel\Fields\Slug;
use MoonShine\Laravel\Resources\ModelResource;
use MoonShine\TinyMce\Fields\TinyMce;
use MoonShine\UI\Components\Collapse;
use MoonShine\UI\Components\Layout\Box;
use MoonShine\UI\Components\Tabs;
use MoonShine\UI\Components\Tabs\Tab;
use MoonShine\UI\Fields\File;
use MoonShine\UI\Fields\ID;
use MoonShine\Contracts\UI\FieldContract;
use MoonShine\Contracts\UI\ComponentContract;
use MoonShine\UI\Fields\Image;
use MoonShine\UI\Fields\Json;
use MoonShine\UI\Fields\Position;
use MoonShine\UI\Fields\Text;

/**
 * @extends ModelResource<Faculty>
 */
class FacultyResource extends ModelResource
{
    protected string $model = Faculty::class;

    protected string $title = 'Faculties';

    /**
     * @return list<FieldContract>
     */
    protected function indexFields(): iterable
    {
        return [
            ID::make()->sortable(),
            Image::make('Изображение', 'preview'),
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
                Tabs::make([
                    Tab::make('RU', [
                        Text::make('Название', 'name_ru'),
                        TinyMce::make('Описание', 'description_ru'),
                        Json::make('Документы', 'documents_ru')
                            ->fields([
                                Position::make(),
                                File::make('document')
                                    ->dir('uploads/faculties/documents')
                                    ->keepOriginalFileName()
                                    ->removable()
                                    ->multiple()
                            ])
                            ->removable(),
                        Json::make('Контакты', 'contacts_ru')
                            ->fields([
                                Position::make(),
                                Text::make('Ключ на русском', 'key'),
                                Text::make('Значение на русском', 'value')
                            ])
                            ->removable(),
                        Slug::make('Slug', 'slug_ru')->from('name_ru')
                    ]),
                    Tab::make('KZ', [
                        Text::make('Название', 'name_kz'),
                        TinyMce::make('Описание', 'description_kz'),
                        Json::make('Документы', 'documents_kz')
                            ->fields([
                                Position::make(),
                                File::make('document')
                                    ->dir('uploads/faculties/documents')
                                    ->keepOriginalFileName()
                                    ->removable()
                                    ->multiple()
                            ])
                            ->removable(),
                        Json::make('Контакты', 'contacts_kz')
                            ->fields([
                                Position::make(),
                                Text::make('Ключ на казахском', 'key'),
                                Text::make('Значение на казахском', 'value')
                            ])
                            ->removable(),
                        Slug::make('Slug', 'slug_kz')->from('name_kz')
                    ]),
                    Tab::make('EN', [
                        Text::make('Название', 'name_en'),
                        TinyMce::make('Описание', 'description_en'),
                        Json::make('Документы', 'documents_en')
                            ->fields([
                                Position::make(),
                                File::make('document')
                                    ->dir('uploads/faculties/documents')
                                    ->keepOriginalFileName()
                                    ->removable()
                                    ->multiple()
                            ])
                            ->removable(),
                        Json::make('Контакты', 'contacts_en')
                            ->fields([
                                Position::make(),
                                Text::make('Ключ на английском', 'key'),
                                Text::make('Значение на английском', 'value')
                            ])
                            ->removable(),
                        Slug::make('Slug', 'slug_en')->from('name_en')
                    ]),
                    Tab::make('Сотрудники', [
                        Json::make('Состав', 'staff_ru')
                            ->fields([
                                Position::make(),
                                Image::make('Фотография', 'photo')
                                    ->dir('uploads/faculties/staff')
                                    ->removable(),
                                Text::make('Имя на русском', 'name_ru'),
                                Text::make('Должность на русском', 'position_ru'),
                                Text::make('Имя на казахском', 'name_kz'),
                                Text::make('Должность на казахском', 'position_kz'),
                                Text::make('Имя на английском', 'name_en'),
                                Text::make('Должность на английском', 'position'),
                            ])
                            ->vertical()
                            ->removable(),
                    ]),
                ]),
                Image::make('Превью (необязательно)', 'preview')
                    ->dir('uploads/faculties/')
                    ->customName(function ($file, $field) {
                        $timestamp = now()->format('Y_m_d_His');
                        return 'divisions_' . $timestamp . "_." . $file->extension();
                    })
                    ->removable(),
                HasMany::make('Кафедры', 'children', 'name_ru', resource: DepartmentResource::class)
                    ->creatable(),
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
     * @param Faculty $item
     *
     * @return array<string, string[]|string>
     * @see https://laravel.com/docs/validation#available-validation-rules
     */
    protected function rules(mixed $item): array
    {
        return [];
    }
}
