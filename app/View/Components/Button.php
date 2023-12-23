<?php

namespace App\View\Components;

use Illuminate\View\Component;

class Button extends Component
{
    public array $class;
    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct(
        public string $type = 'button',
        public string $variant = 'primary',
        array | string $class = [],
    )
    {
        if(!is_array($class)){
            $class = [$class];
        }
        $this->class = $class;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.button');
    }
}
