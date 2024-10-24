<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class Breadcrumbs extends Component
{
    public $menu;
    public $submenu;
    /**
     * Create a new component instance.
     */
    public function __construct($menu, $submenu = null)
    {
        $this->menu = $menu;
        $this->submenu = $submenu;
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.breadcrumbs');
    }
}
