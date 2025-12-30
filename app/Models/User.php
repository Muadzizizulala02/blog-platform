<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        // Add this field for Google OAuth
        'google_id',  
        'role',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    //added relationships and helper methods

    /**
     * Relationship: User has many posts
     */
    public function posts()
    {
        return $this->hasMany(Post::class);
    }
    
    /**
     * Relationship: User has many comments
     */
    public function comments()
    {
        return $this->hasMany(Comment::class);
    }
    
    /**
     * Relationship: User has many likes
     */
    public function likes()
    {
        return $this->hasMany(Like::class);
    }
    
    /**
     * Helper: Check if user is admin
     * Usage: if ($user->isAdmin()) { ... }
     */
    public function isAdmin()
    {
        return $this->role === 'admin';
    }
    
    /**
     * Helper: Check if user is regular user
     */
    public function isUser()
    {
        return $this->role === 'user';
    }
}
