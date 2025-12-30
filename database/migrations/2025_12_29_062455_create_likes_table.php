<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('likes', function (Blueprint $table) {
            $table->id();
            
            // Who liked/disliked
            $table->unsignedBigInteger('user_id');
            
            // Which post
            $table->unsignedBigInteger('post_id');
            
            // Type: 'like' or 'dislike'
            $table->enum('type', ['like', 'dislike']);
            
            $table->timestamps();
            
            // Foreign keys
            $table->foreign('user_id')
                  ->references('id')
                  ->on('users')
                  ->onDelete('cascade');
            
            $table->foreign('post_id')
                  ->references('id')
                  ->on('posts')
                  ->onDelete('cascade');
            
            // One user can only like/dislike a post once
            $table->unique(['user_id', 'post_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('likes');
    }
};