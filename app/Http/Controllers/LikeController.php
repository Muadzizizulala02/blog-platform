<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\Like;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LikeController extends Controller
{
    /**
     * Toggle like on a post
     */
    public function like(Post $post)
    {
        // Check if user already liked/disliked this post
        $existingLike = Like::where('user_id', Auth::id())
                            ->where('post_id', $post->id)
                            ->first();
        
        if ($existingLike) {
            if ($existingLike->type === 'like') {
                // User already liked, so unlike (remove)
                $existingLike->delete();
            } else {
                // User disliked before, change to like
                $existingLike->update(['type' => 'like']);
            }
        } else {
            // Create new like
            Like::create([
                'user_id' => Auth::id(),
                'post_id' => $post->id,
                'type' => 'like',
            ]);
        }
        
        return redirect()->back();
    }

    /**
     * Toggle dislike on a post
     */
    public function dislike(Post $post)
    {
        $existingLike = Like::where('user_id', Auth::id())
                            ->where('post_id', $post->id)
                            ->first();
        
        if ($existingLike) {
            if ($existingLike->type === 'dislike') {
                // User already disliked, so remove
                $existingLike->delete();
            } else {
                // User liked before, change to dislike
                $existingLike->update(['type' => 'dislike']);
            }
        } else {
            // Create new dislike
            Like::create([
                'user_id' => Auth::id(),
                'post_id' => $post->id,
                'type' => 'dislike',
            ]);
        }
        
        return redirect()->back();
    }
}