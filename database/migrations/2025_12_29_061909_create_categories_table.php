<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('categories', function (Blueprint $table) {
            // Auto-incrementing primary key
            $table->id();
            
            // Category name (e.g., "Technology", "Travel")
            $table->string('name');
            
            // URL-friendly version (e.g., "technology", "travel")
            // Unique means no duplicate slugs
            $table->string('slug')->unique();
            
            // Timestamps: created_at and updated_at
            $table->timestamps();
        });
    }

    public function down(): void
    {
        // Drop table on rollback
        Schema::dropIfExists('categories');
    }
};