<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Tag extends Model
{
    use HasFactory;
    
    protected $fillable = [
        'name',
        'slug',
    ];
    
    /**
     * Auto-generate slug from name
     */
    protected static function boot()
    {
        parent::boot();
        
        static::creating(function ($tag) {
            if (empty($tag->slug)) {
                $tag->slug = Str::slug($tag->name);
            }
        });
    }
    
    /**
     * Relationship: Many-to-Many with posts
     * One tag can be on many posts, one post can have many tags
     */
    public function posts()
    {
        // belongsToMany creates many-to-many relationship
        // Uses 'post_tag' pivot table automatically (alphabetical order)
        // withTimestamps() syncs timestamps on pivot table
        return $this->belongsToMany(Post::class)->withTimestamps();
    }
}