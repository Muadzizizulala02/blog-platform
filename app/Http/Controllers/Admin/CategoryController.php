<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class CategoryController extends Controller
{
    /**
     * Display a listing of categories
     */
    public function index()
    {
        // Get all categories with post count
        // withCount() adds a posts_count attribute to each category
        $categories = Category::withCount('posts')->latest()->paginate(15);
        
        return view('admin.categories.index', compact('categories'));
    }

    /**
     * Show the form for creating a new category
     */
    public function create()
    {
        return view('admin.categories.create');
    }

    /**
     * Store a newly created category
     */
    public function store(Request $request)
    {
        // Validate: name must be unique in categories table
        $validated = $request->validate([
            'name' => 'required|string|max:255|unique:categories,name',
        ]);
        
        // Create category (slug auto-generated in model's boot method)
        Category::create([
            'name' => $validated['name'],
            'slug' => Str::slug($validated['name']),
        ]);
        
        return redirect()->route('admin.categories.index')
                         ->with('success', 'Category created successfully!');
    }

    /**
     * Show the form for editing a category
     */
    public function edit(Category $category)
    {
        return view('admin.categories.edit', compact('category'));
    }

    /**
     * Update the specified category
     */
    public function update(Request $request, Category $category)
    {
        // Unique validation except current category
        // 'unique:categories,name,'.$category->id means: 
        // "name must be unique, but ignore this category's current name"
        $validated = $request->validate([
            'name' => 'required|string|max:255|unique:categories,name,'.$category->id,
        ]);
        
        $category->update([
            'name' => $validated['name'],
            'slug' => Str::slug($validated['name']),
        ]);
        
        return redirect()->route('admin.categories.index')
                         ->with('success', 'Category updated successfully!');
    }

    /**
     * Remove the specified category
     */
    public function destroy(Category $category)
    {
        // Check if category has posts
        // Remember: we set onDelete('restrict') in migration
        if ($category->posts()->count() > 0) {
            return redirect()->route('admin.categories.index')
                             ->with('error', 'Cannot delete category with existing posts!');
        }
        
        $category->delete();
        
        return redirect()->route('admin.categories.index')
                         ->with('success', 'Category deleted successfully!');
    }
}