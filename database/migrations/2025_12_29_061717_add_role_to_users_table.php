<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations - executed when you run "php artisan migrate"
     */
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            // Add a 'role' column after 'email'
            // Default value is 'user', can also be 'admin'
            // After existing column 'email'
            $table->string('role')->default('user')->after('email');
            
            // Add google_id column to store Google OAuth ID
            // Nullable because not all users use Google login
            $table->string('google_id')->nullable()->after('email');
        });
    }

    /**
     * Reverse the migrations - executed when you run "php artisan migrate:rollback"
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            // Remove columns if we rollback
            $table->dropColumn(['role', 'google_id']);
        });
    }
};