<?php

declare(strict_types=1);

namespace App\MoonShine\Resources;

use Illuminate\Database\Eloquent\Model;
use App\Models\Department;

use MoonShine\Laravel\Fields\Relationships\BelongsTo;
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
use MoonShine\UI\Fields\Json;
use MoonShine\UI\Fields\Position;
use MoonShine\UI\Fields\Text;

/**
 * @extends ModelResource<Department>
 */
class DepartmentResource extends ModelResource
{
    protected string $model = Department::class;

    protected string $title = 'Кафедры';

    protected string $sortColumn = 'name_ru';

    protected ?PageType $redirectAfterSave = PageType::INDEX;

    /**
     * @return list<FieldContract>
     */
    protected function indexFields(): iterable
    {
        return [
            ID::make()->sortable(),
            Image::make('Превью', 'preview'),
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
                BelongsTo::make('Факультет', 'parent', 'name_ru', FacultyResource::class)
                ->nullable(),
                Tabs::make([
                    Tab::make('RU', [
                        Text::make('Название', 'name_ru'),
                        TinyMce::make('Описание', 'description_ru'),
                        Json::make('Состав', 'staff_ru')
                            ->fields([
                                Position::make(),
                                Image::make('Фотография', 'photo')
                                    ->dir('uploads/departments/staff')
                                    ->customName(function ($file, $field) {
                                        $timestamp = now()->format('Y_m_d_His');
                                        return 'staff_' . $timestamp . "_RU_." . $file->extension();
                                    })
                                    ->removable(),
                                Text::make('Имя на русском', 'name'),
                                Text::make('Должность на русском', 'position')
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
                        Json::make('Состав', 'staff_kz')
                            ->fields([
                                Position::make(),
                                Image::make('Фотография', 'photo')
                                    ->dir('uploads/departments/staff')
                                    ->customName(function ($file, $field) {
                                        $timestamp = now()->format('Y_m_d_His');
                                        return 'staff_' . $timestamp . "_RU_." . $file->extension();
                                    })
                                    ->removable(),
                                Text::make('Имя на казахском', 'name'),
                                Text::make('Должность на казахском', 'position')
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
                        Json::make('Состав', 'staff_en')
                            ->fields([
                                Position::make(),
                                Image::make('Фотография', 'photo')
                                    ->dir('uploads/departments/staff')
                                    ->customName(function ($file, $field) {
                                        $timestamp = now()->format('Y_m_d_His');
                                        return 'staff_' . $timestamp . "_RU_." . $file->extension();
                                    })
                                    ->removable(),
                                Text::make('Имя на английском', 'name'),
                                Text::make('Должность на английском', 'position')
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
                ]),
                Image::make('Превью', 'preview')
                    ->dir('uploads/departments/')
                    ->customName(function ($file, $field) {
                        $timestamp = now()->format('Y_m_d_His');
                        return 'department_' . $timestamp . "_." . $file->extension();
                    })
                    ->removable(),
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
            Image::make('Превью', 'preview'),
            Text::make('Название', 'name_ru'),
            Json::make('Состав', 'staff_ru')
                ->fields([
                    Position::make(),
                    Image::make('Фотография', 'photo')
                        ->dir('uploads/departments/staff')
                        ->customName(function ($file, $field) {
                            $timestamp = now()->format('Y_m_d_His');
                            return 'staff_' . $timestamp . "_RU_." . $file->extension();
                        })
                        ->removable(),
                    Text::make('Имя на русском', 'name'),
                    Text::make('Должность на русском', 'position')
                ])
                ->removable(),
            Json::make('Контакты', 'contacts_ru')
                ->fields([
                    Position::make(),
                    Text::make('Ключ на русском', 'key'),
                    Text::make('Значение на русском', 'value')
                ])
                ->removable(),
            Text::make('Название', 'name_kz'),
            Json::make('Состав', 'staff_kz')
                ->fields([
                    Position::make(),
                    Image::make('Фотография', 'photo')
                        ->dir('uploads/departments/staff')
                        ->customName(function ($file, $field) {
                            $timestamp = now()->format('Y_m_d_His');
                            return 'staff_' . $timestamp . "_RU_." . $file->extension();
                        })
                        ->removable(),
                    Text::make('Имя на казахском', 'name'),
                    Text::make('Должность на казахском', 'position')
                ])
                ->removable(),
            Json::make('Контакты', 'contacts_kz')
                ->fields([
                    Position::make(),
                    Text::make('Ключ на казахском', 'key'),
                    Text::make('Значение на казахском', 'value')
                ])
                ->removable(),
            Text::make('Название', 'name_en'),
            Json::make('Состав', 'staff_en')
                ->fields([
                    Position::make(),
                    Image::make('Фотография', 'photo')
                        ->dir('uploads/departments/staff')
                        ->customName(function ($file, $field) {
                            $timestamp = now()->format('Y_m_d_His');
                            return 'staff_' . $timestamp . "_RU_." . $file->extension();
                        })
                        ->removable(),
                    Text::make('Имя на английском', 'name'),
                    Text::make('Должность на английском', 'position')
                ])
                ->removable(),
            Json::make('Контакты', 'contacts_en')
                ->fields([
                    Position::make(),
                    Text::make('Ключ на английском', 'key'),
                    Text::make('Значение на английском', 'value')
                ])
                ->removable(),
        ];
    }

    /**
     * @param Department $item
     *
     * @return array<string, string[]|string>
     * @see https://laravel.com/docs/validation#available-validation-rules
     */
    protected function rules(mixed $item): array
    {
        return [];
    }
}
