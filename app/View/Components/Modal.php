<?php

namespace App\View\Components;

use Illuminate\View\Component;

class Modal extends Component
{
    /**
     * The alert type.
     *
     * @var string
     */
    public $id;
    public $class;
    public $fnc;
    /**
     * Create a new component instance.
     * @param  string  $id
     * @return void
     */
    public function __construct($id,$class,$fnc)
    {
        $this->id = $id;
        $this->class = $class;
        $this->fnc = $fnc;
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