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

    public function edit(Comment $comment)
    {
        return view('admin.comments.edit', compact('comment'));
    }

    public function update(Request $request, Comment $comment)
    {
        $request->validate([
            'content' => 'required|string|max:1000',
            'is_approved' => 'boolean',
        ]);

        $comment->update([
            'content' => $request->content,
            'is_approved' => $request->boolean('is_approved'),
        ]);

        return redirect()->route('admin.comments.show', $comment)
            ->with('success', 'Comment updated successfully.');
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

        return redirect()->route('admin.comments.index')
            ->with('success', 'Comment deleted successfully.');
    }
}