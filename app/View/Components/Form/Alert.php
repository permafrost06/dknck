<?php

namespace App\View\Components\Form;

use Illuminate\View\Component;

class Alert extends Component
{
    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct(
        public string $message = '',
        public string $type = 'none',
        public array|string $class = []
    ) {
        if (!is_array($class)) {
            $this->class = [$class];
        }
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.form.alert');
    }
}