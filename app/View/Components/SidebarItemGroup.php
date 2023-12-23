<?php

namespace App\View\Components;

use Illuminate\View\Component;
use Route;

class SidebarItemGroup extends Component
{
    public static int $_id = 0;


    public bool $isActive;
    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct(
        array $routes = [],
        public string $g_id = ''
    ) {
        $this->isActive = in_array(Route::currentRouteName(), $routes);
        if (!$g_id) {
            $this->g_id = 'sidenav-g-'.(self::$_id++);
        }
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.sidebar-item-group');
    }
}