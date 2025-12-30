<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Category;
use App\Models\Tag;
use App\Models\Post;
use App\Models\Comment;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     * This creates sample data for testing
     */
    public function run(): void
    {
        // Create admin user
        $admin = User::create([
            'name' => 'Admin User',
            'email' => 'admin@example.com',
            'password' => Hash::make('password'), // Hash the password
            'role' => 'admin',
            'email_verified_at' => now(),
        ]);

        // Create regular user
        $user = User::create([
            'name' => 'John Doe',
            'email' => 'user@example.com',
            'password' => Hash::make('password'),
            'role' => 'user',
            'email_verified_at' => now(),
        ]);

        // Create categories
        $categories = [
            'Technology',
            'Travel',
            'Food',
            'Lifestyle',
            'Business',
        ];

        foreach ($categories as $categoryName) {
            Category::create(['name' => $categoryName]);
        }

        // Create tags
        $tags = [
            'Laravel',
            'PHP',
            'JavaScript',
            'Tutorial',
            'Tips',
            'News',
            'Review',
        ];

        foreach ($tags as $tagName) {
            Tag::create(['name' => $tagName]);
        }

        // Create posts
        $post1 = Post::create([
            'title' => 'Getting Started with Laravel',
            'content' => 'Laravel is a powerful PHP framework that makes web development a joy. In this post, we will explore the basics of Laravel and how to get started building your first application. Laravel provides an elegant syntax and powerful tools that make building web applications faster and more enjoyable.',
            'user_id' => $admin->id,
            'category_id' => 1,
            'published_at' => now(),
        ]);

        // Attach tags to post
        $post1->tags()->attach([1, 2, 4]); // Laravel, PHP, Tutorial

        $post2 = Post::create([
            'title' => 'Top 10 Travel Destinations for 2024',
            'content' => 'Explore the world with our curated list of must-visit destinations. From tropical paradises to historic cities, these locations offer unforgettable experiences for travelers. Whether you are seeking adventure, relaxation, or cultural immersion, these destinations have something for everyone.',
            'user_id' => $admin->id,
            'category_id' => 2,
            'published_at' => now()->subDays(1),
        ]);

        $post2->tags()->attach([6]); // News

        $post3 = Post::create([
            'title' => 'Delicious Pasta Recipes',
            'content' => 'Learn how to make authentic Italian pasta dishes at home. From classic carbonara to creamy alfredo, these recipes will impress your family and friends. We will cover techniques, ingredients, and tips to elevate your pasta-making skills to restaurant quality.',
            'user_id' => $user->id,
            'category_id' => 3,
            'published_at' => now()->subDays(2),
        ]);

        $post3->tags()->attach([5, 7]); // Tips, Review

        // Create comments
        Comment::create([
            'post_id' => $post1->id,
            'user_id' => $user->id,
            'content' => 'Great article! Very helpful for beginners.',
            'status' => 'approved',
        ]);

        Comment::create([
            'post_id' => $post1->id,
            'user_id' => $admin->id,
            'content' => 'Thanks for the feedback!',
            'status' => 'approved',
        ]);

        Comment::create([
            'post_id' => $post2->id,
            'user_id' => $user->id,
            'content' => 'I would love to visit these places!',
            'status' => 'pending', // Pending for moderation
        ]);
    }
}