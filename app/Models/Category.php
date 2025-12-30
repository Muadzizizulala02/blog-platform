<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Category extends Model
{
    use HasFactory;
    
    /**
     * The attributes that are mass assignable.
     * These fields can be filled using Category::create([...])
     */
    protected $fillable = [
        'name',
        'slug',
    ];
    
    /**
     * Boot method - runs when model is initialized
     * Automatically create slug from name when creating category
     */
    protected static function boot()
    {
        parent::boot();
        
        // 'creating' event fires before saving new record
        static::creating(function ($category) {
            // If slug is empty, create it from name
            if (empty($category->slug)) {
                // Str::slug converts "My Category" to "my-category"
                $category->slug = Str::slug($category->name);
            }
        });
    }
    
    /**
     * Relationship: One category has many posts
     * Returns all posts belonging to this category
     */
    public function posts()
    {
        // hasMany means one-to-many relationship
        // This category can have multiple posts
        return $this->hasMany(Post::class);
    }
}