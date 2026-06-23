<?php

namespace App\View\Components\Admin\Layouts;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class Master extends Component
{
    /**
     * Create a new component instance.
     */
    public function __construct(
        public ?string $title = null,
        public ?string $pageTitle = null
    ) {}

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('admin.layouts.master');
    }
}
