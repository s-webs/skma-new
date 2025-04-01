<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class InfoCard extends Component
{
    public string $title;
    public string $link;

    /**
     * Create a new component instance.
     */
    public function __construct(string $title, string $link)
    {
        $this->title = $title;
        $this->link = $link;
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.info-card');
    }
}
