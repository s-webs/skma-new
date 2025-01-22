<?php

declare(strict_types=1);

namespace App\MoonShine\Resources;

use App\MoonShine\Pages\OrgNodeIndexPage;
use App\Models\OrgNode;

use Leeto\MoonShineTree\Resources\TreeResource;
use MoonShine\Laravel\Pages\Crud\DetailPage;
use MoonShine\Laravel\Pages\Crud\FormPage;
use MoonShine\Laravel\Resources\ModelResource;
use MoonShine\Support\Enums\PageType;
use MoonShine\UI\Components\Layout\Box;
use MoonShine\UI\Components\Layout\Divider;
use MoonShine\UI\Components\Tabs;
use MoonShine\UI\Fields\Color;
use MoonShine\UI\Fields\ID;
use MoonShine\Contracts\UI\FieldContract;
use MoonShine\Contracts\UI\ComponentContract;
use MoonShine\UI\Fields\Text;
use MoonShine\UI\Fields\Textarea;

/**
 * @extends ModelResource<OrgNode>
 */
class OrgNodeResource extends TreeResource
{
    protected string $model = OrgNode::class;

    protected string $title = 'Организаионная структура';

    protected string $column = 'name_ru';

    protected string $sortColumn = 'sort_order';

    protected ?PageType $redirectAfterSave = PageType::INDEX;

    protected function pages(): array
    {
        return [
            OrgNodeIndexPage::class,
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
                    Tabs\Tab::make('RU', [
                        Text::make('Название на русском', 'name_ru'),
                        Textarea::make('Описание на русском', 'description_ru'),
                    ]),
                    Tabs\Tab::make('KZ', [
                        Text::make('Название на казахском', 'name_kz'),
                        Textarea::make('Описание на казахском', 'description_kz'),
                    ]),
                    Tabs\Tab::make('EN', [
                        Text::make('Название на английском', 'name_en'),
                        Textarea::make('Описание на английском', 'description_en'),
                    ]),
                ]),
                Divider::make(),
                Color::make('Цвет', 'color')->default('#000000')
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

    public function treeKey(): ?string
    {
        return 'parent_id';
    }

    public function sortKey(): string
    {
        return $this->getSortColumn();
    }
}
