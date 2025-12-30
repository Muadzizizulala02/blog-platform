<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Tag;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class TagController extends Controller
{
    /**
     * Display a listing of tags
     */
    public function index()
    {
        // Get tags with count of posts using each tag
        $tags = Tag::withCount('posts')->latest()->paginate(15);
        
        return view('admin.tags.index', compact('tags'));
    }

    /**
     * Show the form for creating a new tag
     */
    public function create()
    {
        return view('admin.tags.create');
    }

    /**
     * Store a newly created tag
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255|unique:tags,name',
        ]);
        
        Tag::create([
            'name' => $validated['name'],
            'slug' => Str::slug($validated['name']),
        ]);
        
        return redirect()->route('admin.tags.index')
                         ->with('success', 'Tag created successfully!');
    }

    /**
     * Show the form for editing a tag
     */
    public function edit(Tag $tag)
    {
        return view('admin.tags.edit', compact('tag'));
    }

    /**
     * Update the specified tag
     */
    public function update(Request $request, Tag $tag)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255|unique:tags,name,'.$tag->id,
        ]);
        
        $tag->update([
            'name' => $validated['name'],
            'slug' => Str::slug($validated['name']),
        ]);
        
        return redirect()->route('admin.tags.index')
                         ->with('success', 'Tag updated successfully!');
    }

    /**
     * Remove the specified tag
     */
    public function destroy(Tag $tag)
    {
        // Tags can be deleted even if posts use them
        // The pivot table entries will be cascade deleted
        $tag->delete();
        
        return redirect()->route('admin.tags.index')
                         ->with('success', 'Tag deleted successfully!');
    }
}