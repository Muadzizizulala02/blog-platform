<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\Comment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CommentController extends Controller
{
    /**
     * Store a new comment
     */
    public function store(Request $request, Post $post)
    {
        // Validate comment content
        $validated = $request->validate([
            'content' => 'required|string|max:1000',
        ]);
        
        // Create comment with 'pending' status (needs approval)
        $post->comments()->create([
            'user_id' => Auth::id(),
            'content' => $validated['content'],
            'status' => 'pending',  // Admin must approve
        ]);
        
        return redirect()->back()
                         ->with('success', 'Comment submitted and awaiting approval!');
    }

    /**
     * Delete user's own comment
     */
    public function destroy(Comment $comment)
    {
        // Check if current user owns this comment
        if ($comment->user_id !== Auth::id()) {
            abort(403, 'Unauthorized action.');
        }
        
        $comment->delete();
        
        return redirect()->back()->with('success', 'Comment deleted!');
    }
}