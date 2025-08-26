<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class AiAssistantWidget extends Component
{
    public string $locale;

    public function __construct(string $locale = null)
    {
        $this->locale = $locale ?? app()->getLocale();
    }

    public function render(): View|Closure|string
    {
        return view('components.ai-assistant-widget');
    }
}
