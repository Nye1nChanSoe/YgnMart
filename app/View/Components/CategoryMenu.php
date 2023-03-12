<?php

namespace App\View\Components;

use App\Models\Category;
use Illuminate\View\Component;

class CategoryMenu extends Component
{
    /**
     * ID of the category_types table
     */
    public $id;

    /** id passed from blade template :id=record->id */
    public function __construct($id)
    {
        $this->id = $id;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        $categories = Category::where('category_type_id', $this->id)->get();
        return view('components.category-menu', compact('categories'));
    }
}
