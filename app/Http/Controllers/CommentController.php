<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

class CommentController extends Controller
{
    public function store(Request $request, Post $post)
    {
        $request->validate([
            'content' => 'required|string|max:1000',
            'parent_id' => 'nullable|exists:comments,id'
        ]);

        $comment = new Comment();
        $comment->content = $request->content;
        $comment->user_id = auth()->id();
        $comment->post_id = $post->id;
        $comment->parent_id = $request->parent_id;
        $comment->is_approved = true; // Auto-approve for now
        $comment->approved_at = now();
        $comment->save();

        return back()->with('success', 'Comment added successfully.');
    }

    public function destroy(Comment $comment)
    {
        // Check if user can delete the comment
        if (!Gate::allows('delete-comment', $comment)) {
            abort(403, 'Unauthorized action.');
        }

        $comment->delete();
        return back()->with('success', 'Comment deleted successfully.');
    }
}
