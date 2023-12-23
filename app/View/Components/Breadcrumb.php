<?php

namespace App\View\Components;

use Illuminate\View\Component;

class Breadcrumb extends Component
{
    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct(
        public array $home,
        public string $active,
        public string $title = '',
        public array $items = [],
    ) {
        if (!$title) {
            $this->title = $active;
        }
        if (!isset($home['link']) && isset($home['route'])) {
            $this->home['link'] = route($home['route']);
        }
    }


    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.breadcrumb');
    }
}