<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Traits\ParseTrait;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

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

    public function store(Request $request)
    {
        $categoryInfo = $request->validate([
            'type' => ['required', 'max:25'],
            'sub_type' => ['required', 'max:18', Rule::unique('categories', 'sub_type')],
            'description' => ['required', 'max:255'],
        ]);

        Category::create($categoryInfo);

        return back()->with('success', 'Category added!');
    }

    public function show(Category $category)
    {
        return view('admins.categories.show', compact('category'));
    }

    public function destroy(Request $request, Category $category)
    {
        if(!Hash::check($request->input('password'), auth()->user()->password)) {
            return back()->with('error', 'Incorrect password');
        }

        $category->delete();
        return redirect()->route('admin.categories')->with('success', "Category {$category->sub_type} removed");
    }
}
