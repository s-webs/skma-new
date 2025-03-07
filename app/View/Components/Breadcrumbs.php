<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class Breadcrumbs extends Component
{
    public array $items;

    public function __construct(array $items)
    {
        $this->items = $items;
    }

    public function render(): \Illuminate\Contracts\View\Factory|\Illuminate\Foundation\Application|View|\Illuminate\Contracts\Support\Htmlable|string|Closure|\Illuminate\View\View
    {
        return view('components.breadcrumbs');
    }
}
