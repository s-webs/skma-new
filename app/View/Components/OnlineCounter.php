<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class OnlineCounter extends Component
{
    public $count;
    public $field;
    public $extraClasses;

    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct($count, $field, $extraClasses = '')
    {
        $this->count = $count;
        $this->field = $field;
        $this->extraClasses = $extraClasses;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.online-counter');
    }
}
