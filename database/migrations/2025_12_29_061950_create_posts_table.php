<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('posts', function (Blueprint $table) {
            $table->id();
            
            // Post title
            $table->string('title');
            
            // URL-friendly slug for the post
            $table->string('slug')->unique();
            
            // Post content - longText allows very long articles
            $table->longText('content');
            
            // Foreign key to users table (who created this post)
            // unsignedBigInteger matches the id type in users table
            $table->unsignedBigInteger('user_id');
            
            // Foreign key to categories table
            $table->unsignedBigInteger('category_id');
            
            // When the post was published (can be scheduled for future)
            // Nullable because drafts might not have a publish date yet
            $table->timestamp('published_at')->nullable();
            
            $table->timestamps();
            
            // Define foreign key constraints
            // When a user is deleted, delete their posts too (cascade)
            $table->foreign('user_id')
                  ->references('id')
                  ->on('users')
                  ->onDelete('cascade');
            
            // When a category is deleted, prevent deletion if posts exist
            $table->foreign('category_id')
                  ->references('id')
                  ->on('categories')
                  ->onDelete('restrict');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('posts');
    }
};