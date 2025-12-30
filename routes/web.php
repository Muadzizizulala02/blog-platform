<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Auth\GoogleAuthController;
use App\Http\Controllers\BlogController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\LikeController;
use App\Http\Controllers\Admin\PostController as AdminPostController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\TagController;
use App\Http\Controllers\Admin\CommentController as AdminCommentController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Public Routes (Anyone can access)
|--------------------------------------------------------------------------
*/

// Homepage - shows all blog posts
Route::get('/', [BlogController::class, 'index'])->name('home');

// View single post by slug
Route::get('/post/{slug}', [BlogController::class, 'show'])->name('blog.show');

// View posts by category
Route::get('/category/{slug}', [BlogController::class, 'category'])->name('blog.category');

// View posts by tag
Route::get('/tag/{slug}', [BlogController::class, 'tag'])->name('blog.tag');

/*
|--------------------------------------------------------------------------
| Google OAuth Routes
|--------------------------------------------------------------------------
*/

// Redirect to Google login page
Route::get('auth/google', [GoogleAuthController::class, 'redirectToGoogle'])
    ->name('auth.google');

// Handle Google callback
Route::get('auth/google/callback', [GoogleAuthController::class, 'handleGoogleCallback']);

/*
|--------------------------------------------------------------------------
| Authenticated User Routes (Must be logged in)
|--------------------------------------------------------------------------
*/

Route::middleware('auth')->group(function () {
    
    // Dashboard
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');

    // Profile management (from Breeze)
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Comment on posts
    Route::post('/post/{post}/comment', [CommentController::class, 'store'])
        ->name('comments.store');
    
    // Delete own comment
    Route::delete('/comment/{comment}', [CommentController::class, 'destroy'])
        ->name('comments.destroy');

    // Like/Dislike posts
    Route::post('/post/{post}/like', [LikeController::class, 'like'])
        ->name('posts.like');
    Route::post('/post/{post}/dislike', [LikeController::class, 'dislike'])
        ->name('posts.dislike');
});

/*
|--------------------------------------------------------------------------
| Admin Routes (Only admins can access)
|--------------------------------------------------------------------------
*/

// Prefix all admin routes with '/admin'
// Apply 'auth' middleware (must be logged in)
// Apply 'admin' middleware (must have admin role)
Route::prefix('admin')
    ->middleware(['auth', 'admin'])
    ->name('admin.')
    ->group(function () {
        
        // Posts CRUD
        // resource() creates all RESTful routes automatically:
        // GET    /admin/posts          -> index   (list all)
        // GET    /admin/posts/create   -> create  (show form)
        // POST   /admin/posts          -> store   (save new)
        // GET    /admin/posts/{id}     -> show    (view one)
        // GET    /admin/posts/{id}/edit -> edit   (show edit form)
        // PUT    /admin/posts/{id}     -> update  (save changes)
        // DELETE /admin/posts/{id}     -> destroy (delete)
        Route::resource('posts', AdminPostController::class);
        
        // Categories CRUD
        Route::resource('categories', CategoryController::class);
        
        // Tags CRUD
        Route::resource('tags', TagController::class);
        
        // Comment moderation
        Route::get('comments', [AdminCommentController::class, 'index'])
            ->name('comments.index');
        Route::post('comments/{comment}/approve', [AdminCommentController::class, 'approve'])
            ->name('comments.approve');
        Route::post('comments/{comment}/reject', [AdminCommentController::class, 'reject'])
            ->name('comments.reject');
        Route::delete('comments/{comment}', [AdminCommentController::class, 'destroy'])
            ->name('comments.destroy');
    });

// Include authentication routes from Breeze (login, register, etc.)
require __DIR__.'/auth.php';