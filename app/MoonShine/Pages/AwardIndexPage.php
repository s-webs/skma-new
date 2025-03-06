<?php

declare(strict_types=1);

namespace App\MoonShine\Pages;

use Leeto\MoonShineTree\View\Components\TreeComponent;
use MoonShine\Laravel\Pages\Crud\IndexPage;
use MoonShine\Contracts\UI\ComponentContract;
use MoonShine\Contracts\UI\FieldContract;
use Throwable;

class AwardIndexPage extends IndexPage
{
    protected function mainLayer(): array
    {
        return [
            ...$this->getPageButtons(),
            TreeComponent::make($this->getResource()),
        ];
    }
}
