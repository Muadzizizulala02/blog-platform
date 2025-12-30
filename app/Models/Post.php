<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Post extends Model
{
    use HasFactory;
    
    protected $fillable = [
        'title',
        'slug',
        'content',
        'user_id',
        'category_id',
        'published_at',
    ];
    
    /**
     * Cast attributes to specific types
     * published_at will be a Carbon date object
     */
    protected $casts = [
        'published_at' => 'datetime',
    ];
    
    /**
     * Auto-generate slug from title
     */
    protected static function boot()
    {
        parent::boot();
        
        static::creating(function ($post) {
            if (empty($post->slug)) {
                $post->slug = Str::slug($post->title);
            }
        });
    }
    
    /**
     * Relationship: Post belongs to one user (author)
     */
    public function user()
    {
        // belongsTo creates inverse of hasMany
        // This post belongs to one user
        return $this->belongsTo(User::class);
    }
    
    /**
     * Relationship: Post belongs to one category
     */
    public function category()
    {
        return $this->belongsTo(Category::class);
    }
    
    /**
     * Relationship: Many-to-Many with tags
     */
    public function tags()
    {
        return $this->belongsToMany(Tag::class)->withTimestamps();
    }
    
    /**
     * Relationship: Post has many comments
     */
    public function comments()
    {
        return $this->hasMany(Comment::class);
    }
    
    /**
     * Relationship: Post has many likes
     */
    public function likes()
    {
        return $this->hasMany(Like::class);
    }
    
    /**
     * Scope: Only get published posts
     * Usage: Post::published()->get()
     */
    public function scopePublished($query)
    {
        // whereNotNull checks if published_at is not empty
        // where checks if published_at is in the past
        return $query->whereNotNull('published_at')
                     ->where('published_at', '<=', now());
    }
    
    /**
     * Helper: Count total likes
     */
    public function likesCount()
    {
        return $this->likes()->where('type', 'like')->count();
    }
    
    /**
     * Helper: Count total dislikes
     */
    public function dislikesCount()
    {
        return $this->likes()->where('type', 'dislike')->count();
    }
}