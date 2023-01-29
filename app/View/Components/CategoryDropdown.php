<?php

namespace App\View\Components;

use App\Models\Category;
use App\Models\CategoryType;
use Illuminate\View\Component;

class CategoryDropdown extends Component
{
    /**
     * ID of the category_types table
     */
    public $id;

    public function __construct($id)
    {
        $this->id = $id;
    }

    public function render()
    {
        return view('components.category-dropdown', [
            'categories' => Category::where('category_type_id', $this->id)->get(),
        ]);
    }
}
