<?php

declare(strict_types=1);

namespace App\MoonShine\Resources;

use App\MoonShine\Pages\AwardIndexPage;
use Illuminate\Database\Eloquent\Model;
use App\Models\Award;

use Leeto\MoonShineTree\Resources\TreeResource;
use MoonShine\Laravel\Pages\Crud\DetailPage;
use MoonShine\Laravel\Pages\Crud\FormPage;
use MoonShine\Laravel\Resources\ModelResource;
use MoonShine\Support\Enums\PageType;
use MoonShine\UI\Components\Layout\Box;
use MoonShine\UI\Components\Tabs;
use MoonShine\UI\Components\Tabs\Tab;
use MoonShine\UI\Fields\ID;
use MoonShine\Contracts\UI\FieldContract;
use MoonShine\Contracts\UI\ComponentContract;
use MoonShine\UI\Fields\Image;
use MoonShine\UI\Fields\Switcher;
use MoonShine\UI\Fields\Text;

/**
 * @extends ModelResource<Award>
 */
class AwardResource extends TreeResource
{
    protected string $model = Award::class;

    protected string $title = 'Награды и достижения';

    protected string $column = 'image_ru';
    protected string $sortColumn = 'sort_order';
    protected ?PageType $redirectAfterSave = PageType::INDEX;


    protected function pages(): array
    {
        return [
            AwardIndexPage::class,
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
                        Image::make('Изображение', 'image_ru')
                            ->dir('uploads/awards/')
                            ->customName(function ($file, $field) {
                                $timestamp = now()->format('Y_m_d_His');
                                return 'award_' . $timestamp . "_RU_." . $file->extension();
                            })
                            ->removable(),
                    ]),
                    Tab::make('KZ', [
                        Text::make('Название', 'name_kz'),
                        Image::make('Изображение', 'image_kz')
                            ->dir('uploads/awards/')
                            ->customName(function ($file, $field) {
                                $timestamp = now()->format('Y_m_d_His');
                                return 'award_' . $timestamp . "_KZ_." . $file->extension();
                            })
                            ->removable(),
                    ]),
                    Tab::make('EN', [
                        Text::make('Название', 'name_en'),
                        Image::make('Изображение', 'image_en')
                            ->dir('uploads/awards/')
                            ->customName(function ($file, $field) {
                                $timestamp = now()->format('Y_m_d_His');
                                return 'award_' . $timestamp . "_EN_." . $file->extension();
                            })
                            ->removable(),
                    ]),
                ]),
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
     * @param Award $item
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
        return null;
    }

    public function sortKey(): string
    {
        return $this->getSortColumn();
    }

}
