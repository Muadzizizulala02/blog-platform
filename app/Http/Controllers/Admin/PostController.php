<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Post;
use App\Models\Category;
use App\Models\Tag;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class PostController extends Controller
{
    /**
     * Display a listing of all posts
     * GET /admin/posts
     */
    public function index()
    {
        // Get all posts with their relationships loaded (eager loading)
        // with() prevents N+1 query problem
        // latest() orders by created_at descending (newest first)
        // paginate(15) shows 15 posts per page with pagination links
        $posts = Post::with(['user', 'category', 'tags'])
                     ->latest()
                     ->paginate(15);
        
        // Return view with $posts variable
        return view('admin.posts.index', compact('posts'));
    }

    /**
     * Show the form for creating a new post
     * GET /admin/posts/create
     */
    public function create()
    {
        // Get all categories for dropdown
        $categories = Category::all();
        
        // Get all tags for multi-select
        $tags = Tag::all();
        
        // Pass data to view
        return view('admin.posts.create', compact('categories', 'tags'));
    }

    /**
     * Store a newly created post in database
     * POST /admin/posts
     */
    public function store(Request $request)
    {
        // Validate incoming request data
        // Rules define what data is acceptable
        $validated = $request->validate([
            'title' => 'required|string|max:255',        // Required, must be string, max 255 chars
            'content' => 'required|string',              // Required, any length string
            'category_id' => 'required|exists:categories,id',  // Must exist in categories table
            'tags' => 'array',                           // Optional, must be array if provided
            'tags.*' => 'exists:tags,id',               // Each tag must exist in tags table
            'published_at' => 'nullable|date',           // Optional, must be valid date format
        ]);
        
        // Create the post
        $post = Post::create([
            'title' => $validated['title'],
            'slug' => Str::slug($validated['title']),   // Auto-generate slug from title
            'content' => $validated['content'],
            'user_id' => Auth::id(),                   // Current logged-in user's ID
            'category_id' => $validated['category_id'],
            'published_at' => $validated['published_at'] ?? now(),  // Use provided date or now
        ]);
        
        // Attach tags to post using Many-to-Many relationship
        // This inserts records into post_tag pivot table
        if (isset($validated['tags'])) {
            $post->tags()->attach($validated['tags']);
        }
        
        // Redirect back to posts list with success message
        // with() adds data to session for one request (flash data)
        return redirect()->route('admin.posts.index')
                         ->with('success', 'Post created successfully!');
    }

    /**
     * Display the specified post
     * GET /admin/posts/{post}
     */
    public function show(Post $post)
    {
        // Load relationships for display
        $post->load(['user', 'category', 'tags', 'comments.user']);
        
        return view('admin.posts.show', compact('post'));
    }

    /**
     * Show the form for editing the specified post
     * GET /admin/posts/{post}/edit
     */
    public function edit(Post $post)
    {
        // Get categories and tags for dropdowns
        $categories = Category::all();
        $tags = Tag::all();
        
        // Pass post and related data to view
        return view('admin.posts.edit', compact('post', 'categories', 'tags'));
    }

    /**
     * Update the specified post in database
     * PUT/PATCH /admin/posts/{post}
     */
    public function update(Request $request, Post $post)
    {
        // Validate updated data
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string',
            'category_id' => 'required|exists:categories,id',
            'tags' => 'array',
            'tags.*' => 'exists:tags,id',
            'published_at' => 'nullable|date',
        ]);
        
        // Update post with new data
        $post->update([
            'title' => $validated['title'],
            'slug' => Str::slug($validated['title']),
            'content' => $validated['content'],
            'category_id' => $validated['category_id'],
            'published_at' => $validated['published_at'] ?? $post->published_at,
        ]);
        
        // Sync tags - removes old associations and creates new ones
        // sync() is better than detach() + attach() for updates
        if (isset($validated['tags'])) {
            $post->tags()->sync($validated['tags']);
        } else {
            // If no tags selected, remove all tag associations
            $post->tags()->detach();
        }
        
        return redirect()->route('admin.posts.index')
                         ->with('success', 'Post updated successfully!');
    }

    /**
     * Remove the specified post from database
     * DELETE /admin/posts/{post}
     */
    public function destroy(Post $post)
    {
        // Delete post (cascade will delete related comments, likes, etc.)
        $post->delete();
        
        return redirect()->route('admin.posts.index')
                         ->with('success', 'Post deleted successfully!');
    }
}