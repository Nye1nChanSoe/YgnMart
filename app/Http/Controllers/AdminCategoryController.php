<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Traits\ParseTrait;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class AdminCategoryController extends Controller
{
    use ParseTrait;

    public function index()
    {
        $categories = Cache::remember('admin:category', '300', function() {
            Category::latest()
            ->search($this->parseHyphens(request(['search'])))
            ->paginate(25);
        });

        return view('admins.categories.index', compact('categories'));
    }
}
