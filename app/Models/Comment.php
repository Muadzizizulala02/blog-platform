<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    use HasFactory;
    
    protected $fillable = [
        'post_id',
        'user_id',
        'content',
        'status',
    ];
    
    /**
     * Relationship: Comment belongs to one post
     */
    public function post()
    {
        return $this->belongsTo(Post::class);
    }
    
    /**
     * Relationship: Comment belongs to one user
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }
    
    /**
     * Scope: Only approved comments
     * Usage: Comment::approved()->get()
     */
    public function scopeApproved($query)
    {
        return $query->where('status', 'approved');
    }
    
    /**
     * Scope: Pending comments (for moderation)
     */
    public function scopePending($query)
    {
        return $query->where('status', 'pending');
    }
}