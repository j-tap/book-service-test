<?php

namespace App\View\Components\Forms;

use Illuminate\View\Component;

class Select extends Component
{
    public $name;
    public $value;
    public $validation;
    public $items;
    public $label;
    public $multiple;

    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct($name, $value, $validation, $items, $multiple = null)
    {
        $this->name = $name;
        $this->value = $value;
        $this->validation = $validation;
        $this->items = $items;
        $this->multiple = $multiple ? 'multiple' : '';
        $this->label = ucfirst(str_replace('_', ' ', $name));
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.forms.select');
    }
}
