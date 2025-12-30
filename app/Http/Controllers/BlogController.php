<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\Category;
use App\Models\Tag;
use Illuminate\Http\Request;

class BlogController extends Controller
{
    /**
     * Display all published posts (homepage)
     */
    public function index()
    {
        // Only show published posts (using scope from Post model)
        // Eager load relationships to avoid N+1 queries
        $posts = Post::published()
                     ->with(['user', 'category', 'tags'])
                     ->latest('published_at')
                     ->paginate(10);
        
        return view('blog.index', compact('posts'));
    }

    /**
     * Display a single post by slug
     */
    public function show($slug)
    {
        // Find post by slug, or return 404 if not found
        $post = Post::where('slug', $slug)
                    ->published()
                    ->with(['user', 'category', 'tags'])
                    ->firstOrFail();
        
        // Get only approved comments for this post
        $comments = $post->comments()
                         ->approved()
                         ->with('user')
                         ->latest()
                         ->get();
        
        return view('blog.show', compact('post', 'comments'));
    }

    /**
     * Display posts by category
     */
    public function category($slug)
    {
        // Find category or 404
        $category = Category::where('slug', $slug)->firstOrFail();
        
        // Get published posts in this category
        $posts = $category->posts()
                          ->published()
                          ->with(['user', 'tags'])
                          ->latest('published_at')
                          ->paginate(10);
        
        return view('blog.category', compact('category', 'posts'));
    }

    /**
     * Display posts by tag
     */
    public function tag($slug)
    {
        // Find tag or 404
        $tag = Tag::where('slug', $slug)->firstOrFail();
        
        // Get published posts with this tag
        $posts = $tag->posts()
                     ->published()
                     ->with(['user', 'category'])
                     ->latest('published_at')
                     ->paginate(10);
        
        return view('blog.tag', compact('tag', 'posts'));
    }
}