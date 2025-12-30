<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('post_tag', function (Blueprint $table) {
            // No primary key needed, but we'll add one for best practice
            $table->id();
            
            // Foreign key to posts table
            $table->unsignedBigInteger('post_id');
            
            // Foreign key to tags table
            $table->unsignedBigInteger('tag_id');
            
            // Timestamps optional for pivot tables
            $table->timestamps();
            
            // Foreign key constraints
            $table->foreign('post_id')
                  ->references('id')
                  ->on('posts')
                  ->onDelete('cascade'); // Delete associations when post deleted
            
            $table->foreign('tag_id')
                  ->references('id')
                  ->on('tags')
                  ->onDelete('cascade'); // Delete associations when tag deleted
            
            // Prevent duplicate post-tag combinations
            $table->unique(['post_id', 'tag_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('post_tag');
    }
};