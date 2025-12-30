<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Comment;
use Illuminate\Http\Request;

class CommentController extends Controller
{
    /**
     * Display all comments for moderation
     */
    public function index()
    {
        // Get all comments with user and post info
        // Latest comments first
        $comments = Comment::with(['user', 'post'])
                           ->latest()
                           ->paginate(20);
        
        return view('admin.comments.index', compact('comments'));
    }

    /**
     * Approve a comment
     */
    public function approve(Comment $comment)
    {
        // Change status to 'approved'
        $comment->update(['status' => 'approved']);
        
        return redirect()->back()->with('success', 'Comment approved!');
    }

    /**
     * Reject a comment
     */
    public function reject(Comment $comment)
    {
        // Change status to 'rejected'
        $comment->update(['status' => 'rejected']);
        
        return redirect()->back()->with('success', 'Comment rejected!');
    }

    /**
     * Delete a comment permanently
     */
    public function destroy(Comment $comment)
    {
        $comment->delete();
        
        return redirect()->back()->with('success', 'Comment deleted!');
    }
}