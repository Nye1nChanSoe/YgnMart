<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Traits\ParseTrait;
use Illuminate\Http\Request;

class AdminCategoryController extends Controller
{
    use ParseTrait;

    public function index()
    {
        $categories = Category::latest()
            ->search($this->parseHyphens(request(['search'])))
            ->paginate(25);

        return view('admins.categories.index', compact('categories'));
    }
}
