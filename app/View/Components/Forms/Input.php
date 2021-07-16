<?php

namespace App\View\Components\Forms;

use Illuminate\View\Component;

class Input extends Component
{
    public $name;
    public $validation;
    public $label;
    public $type;

    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct($name, $validation, $type = 'text')
    {
        $this->name = $name;
        $this->validation = $validation;
        $this->type = $type;
        $this->label = ucfirst(str_replace('_', ' ', $name));
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.forms.input');
    }
}
