<?php

declare(strict_types=1);

namespace App\MoonShine\Resources;

use App\MoonShine\Pages\DivisionsIndexPage;
use App\Models\Division;

use Leeto\MoonShineTree\Resources\TreeResource;
use MoonShine\Laravel\Fields\Relationships\BelongsTo;
use MoonShine\Laravel\Fields\Slug;
use MoonShine\Laravel\Pages\Crud\DetailPage;
use MoonShine\Laravel\Pages\Crud\FormPage;
use MoonShine\Laravel\Resources\ModelResource;
use MoonShine\Support\Enums\PageType;
use MoonShine\TinyMce\Fields\TinyMce;
use MoonShine\UI\Components\Collapse;
use MoonShine\UI\Components\Layout\Box;
use MoonShine\UI\Components\Layout\Divider;
use MoonShine\UI\Components\Tabs;
use MoonShine\UI\Components\Tabs\Tab;
use MoonShine\UI\Fields\File;
use MoonShine\UI\Fields\ID;
use MoonShine\Contracts\UI\FieldContract;
use MoonShine\Contracts\UI\ComponentContract;
use MoonShine\UI\Fields\Image;
use MoonShine\UI\Fields\Json;
use MoonShine\UI\Fields\Number;
use MoonShine\UI\Fields\Position;
use MoonShine\UI\Fields\Text;

/**
 * @extends ModelResource<Division>
 */
class DivisionResource extends TreeResource
{

    protected string $model = Division::class;

    protected string $title = 'Подразделения';

    protected string $column = 'name_ru';

    protected string $sortColumn = 'sort_order';

    protected ?PageType $redirectAfterSave = PageType::INDEX;

    protected function pages(): array
    {
        return [
            DivisionsIndexPage::class,
            FormPage::class,
            DetailPage::class,
        ];
    }

    /**
     * @return list<FieldContract>
     */
    protected function indexFields(): iterable
    {
        return [
            ID::make()->sortable(),
            BelongsTo::make('Родитель', 'parent', 'name_ru', resource: DivisionResource::class)
                ->badge(),
            Text::make('Название', 'name_ru'),
            Slug::make('Slug', 'slug_ru'),
            Number::make('Сортировка', 'sort_order'),
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
                BelongsTo::make('Родитель', 'parent', 'name_ru', resource: DivisionResource::class)
                    ->searchable()
                    ->nullable(),
                Collapse::make('Основное', [
                    Tabs::make([
                        Tab::make('RU', [
                            Text::make('Название', 'name_ru'),
                            TinyMce::make('Описание', 'description_ru'),
                            Json::make('Состав', 'staff_ru')
                                ->fields([
                                    Position::make(),
                                    Image::make('Фотография', 'photo')
                                        ->dir('uploads/divisions/staff')
                                        ->removable(),
                                    Text::make('Имя на русском', 'name'),
                                    Text::make('Должность на русском', 'position')
                                ])
                                ->removable(),
                            Json::make('Документы', 'documents_ru')
                                ->fields([
                                    Position::make(),
                                    File::make('document')
                                        ->dir('uploads/divisions/documents')
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
                            Json::make('Состав', 'staff_kz')
                                ->fields([
                                    Position::make(),
                                    Image::make('Фотография', 'photo')
                                        ->dir('uploads/divisions/staff')
                                        ->removable(),
                                    Text::make('Имя на казахском', 'name'),
                                    Text::make('Должность на казахском', 'position')
                                ])
                                ->removable(),
                            Json::make('Документы', 'documents_kz')
                                ->fields([
                                    Position::make(),
                                    File::make('document')
                                        ->dir('uploads/divisions/documents')
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
                            Json::make('Состав', 'staff_en')
                                ->fields([
                                    Position::make(),
                                    Image::make('Фотография', 'photo')
                                        ->dir('uploads/divisions/staff')
                                        ->removable(),
                                    Text::make('Имя на английском', 'name'),
                                    Text::make('Должность на английском', 'position')
                                ])
                                ->removable(),
                            Json::make('Документы', 'documents_en')
                                ->fields([
                                    Position::make(),
                                    File::make('document')
                                        ->dir('uploads/divisions/documents')
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
                    ]),
                    Divider::make(),
                    Image::make('Превью (необязательно)', 'preview')
                        ->dir('uploads/divisions/')
                        ->customName(function ($file, $field) {
                            $timestamp = now()->format('Y_m_d_His');
                            return 'divisions_' . $timestamp . "_." . $file->extension();
                        })
                        ->removable(),
                    Number::make('Сортировка', 'sort_order')->default(0)
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
     * @param Division $item
     *
     * @return array<string, string[]|string>
     * @see https://laravel.com/docs/validation#available-validation-rules
     */
    protected function rules(mixed $item): array
    {
        return [];
    }

    public function treeKey(): ?string
    {
        return 'parent_id';
    }

    public function sortKey(): string
    {
        return $this->getSortColumn();
    }
}
