<?php

declare(strict_types=1);

namespace App\MoonShine\Resources;

use App\MoonShine\Pages\MenuIndexPage;
use Illuminate\Database\Eloquent\Model;
use App\Models\Menu;

use Leeto\MoonShineTree\Resources\TreeResource;
use MoonShine\AssetManager\Css;
use MoonShine\AssetManager\Js;
use MoonShine\Laravel\Pages\Crud\DetailPage;
use MoonShine\Laravel\Pages\Crud\FormPage;
use MoonShine\Laravel\Resources\ModelResource;
use MoonShine\Support\Enums\PageType;
use MoonShine\UI\Components\Layout\Box;
use MoonShine\UI\Components\Layout\Divider;
use MoonShine\UI\Components\Link;
use MoonShine\UI\Components\Tabs;
use MoonShine\UI\Components\Tabs\Tab;
use MoonShine\UI\Fields\ID;
use MoonShine\Contracts\UI\FieldContract;
use MoonShine\Contracts\UI\ComponentContract;
use MoonShine\UI\Fields\Select;
use MoonShine\UI\Fields\Text;
use MoonShine\UI\Fields\Url;

class MenuResource extends TreeResource
{
    protected string $model = Menu::class;

    protected string $title = 'Меню';

    protected string $column = 'name_ru';

    protected string $sortColumn = 'order';

    protected function assets(): array
    {
        return [
            Css::make(asset('/assets/css/all.min.css')),
            Js::make(asset('/assets/js/pro.min.js')),
        ];
    }

    protected ?PageType $redirectAfterSave = PageType::INDEX;


    protected function pages(): array
    {
        return [
            MenuIndexPage::class,
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
                        Text::make('Название на русском', 'name_ru'),
                        Text::make('Ссылка на русском (В родительских пунктах ссылка работать не будет)', 'link_ru'),
                    ]),
                    Tab::make('KZ', [
                        Text::make('Название на казахском', 'name_kz'),
                        Text::make('Ссылка на казахском (В родительских пунктах ссылка работать не будет)', 'link_kz'),
                    ]),
                    Tab::make('EN', [
                        Text::make('Название на английском', 'name_en'),
                        Text::make('Ссылка на английском (В родительских пунктах ссылка работать не будет)', 'link_en'),
                    ]),
                ]),
                Text::make('Иконка', 'icon')->unescape(),
                Divider::make(),
                Link::make('https://fontawesome.com/v5/search?o=r&s=light', 'Тут можно посмотреть список иконок')
                    ->icon('arrow-top-right-on-square')
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

    public function search(): array
    {
        return ['id', 'name_ru', 'name_kz', 'name_en'];
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
