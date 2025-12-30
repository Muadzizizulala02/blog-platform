<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('comments', function (Blueprint $table) {
            $table->id();
            
            // Which post this comment belongs to
            $table->unsignedBigInteger('post_id');
            
            // Who wrote the comment
            $table->unsignedBigInteger('user_id');
            
            // The comment text
            $table->text('content');
            
            // Status: 'pending', 'approved', 'rejected'
            // Default is pending for moderation
            $table->string('status')->default('pending');
            
            $table->timestamps();
            
            // Foreign keys
            $table->foreign('post_id')
                  ->references('id')
                  ->on('posts')
                  ->onDelete('cascade'); // Delete comments when post deleted
            
            $table->foreign('user_id')
                  ->references('id')
                  ->on('users')
                  ->onDelete('cascade'); // Delete comments when user deleted
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('comments');
    }
};