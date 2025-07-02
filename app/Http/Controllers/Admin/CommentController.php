<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Comment;
use Illuminate\Http\Request;

class CommentController extends Controller
{
    public function index()
    {
        $comments = Comment::with(['user', 'post'])
            ->latest()
            ->paginate(10);

        return view('admin.comments.index', compact('comments'));
    }

    public function show(Comment $comment)
    {
        $comment->load(['user', 'post', 'parent.user']);
        return view('admin.comments.show', compact('comment'));
    }

    public function approve(Comment $comment)
    {
        $comment->update(['is_approved' => !$comment->is_approved]);

        $status = $comment->is_approved ? 'approved' : 'unapproved';
        return back()->with('success', "Comment {$status} successfully.");
    }

    public function destroy(Comment $comment)
    {
        $comment->delete();
        return redirect()->route('admin.comments.index')->with('success', 'Comment deleted successfully.');
    }
}
