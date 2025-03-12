<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class LinkCard extends Component
{
    public string $url;
    public string $title;
    public string $subtitle;
    public function __construct(string $url, string $title, string $subtitle)
    {
        $this->url = $url;
        $this->title = $title;
        $this->subtitle = $subtitle;
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.link-card');
    }
}
