<?php

namespace App\View\Components\Form;

use Illuminate\View\Component;

class Select extends Component
{
    private static int $count = 0;
    public array $class;

    /**
     * Create a new component instance.
     */
    public function __construct(
        public string $label = '',
        public string $hint = '',
        public string $groupId = '',
        public string $hintType = 'error',
        public string $theme = 'admin',
        public string $id = '',
        array | string $class = 'mb-2',
    )
    {
        if(!is_array($class)){
            $class = [$class];
        }
        $this->class = $class;
        if(!$id){
            $this->id = '_select_id_'.(self::$count++);
        }
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.form.select');
    }
}
