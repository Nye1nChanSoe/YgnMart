<?php

namespace App\View\Components;

use Illuminate\Support\Facades\DB;
use Illuminate\View\Component;

class CategoryDropDown extends Component
{
    /**
     * Main category type
     */
    public $type;

    public function __construct($type)
    {
        $this->type = $type;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        $subTypes = DB::table('categories')
            ->where('type', $this->type)
            ->pluck('sub_type');
        return view('components.category-dropdown', compact('subTypes'));
    }
}
