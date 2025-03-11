<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class SearchResultsBlock extends Component
{
    public $title;
    public $results;
    public $route;
    public $field;

    public function __construct($title, $results, $route, $field)
    {
        $this->title = $title;
        $this->results = $results;
        $this->route = $route;
        $this->field = $field;
    }

    public function render()
    {
        return view('components.search-results-block');
    }
}
