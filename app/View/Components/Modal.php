<?php

namespace App\View\Components;

use Illuminate\View\Component;

class Modal extends Component
{
    public $name;
    public $title;
    public $successEvent;

    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct($name, $title, $successEvent)
    {
        $this->name = $name;
        $this->title = $title;
        $this->successEvent = $successEvent;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.modal');
    }
}
