<?php

namespace App\Livewire;

use App\Models\Post;
use App\Models\Comment;
use Livewire\Component;

class CommentSection extends Component
{
    public Post $post;
    public $newComment = '';
    public $replyingTo = null;
    public $showCommentForm = false;

    protected $rules = [
        'newComment' => 'required|string|max:1000|min:3',
    ];

    protected $messages = [
        'newComment.required' => 'Please enter a comment.',
        'newComment.min' => 'Comment must be at least 3 characters.',
        'newComment.max' => 'Comment cannot exceed 1000 characters.',
    ];

    public function mount(Post $post)
    {
        $this->post = $post;
    }

    public function toggleCommentForm()
    {
        if (!auth()->check()) {
            return redirect()->route('login');
        }

        $this->showCommentForm = !$this->showCommentForm;
        $this->resetValidation();
    }

    public function submitComment()
    {
        if (!auth()->check()) {
            return redirect()->route('login');
        }

        $this->validate();

        $this->post->comments()->create([
            'content' => $this->newComment,
            'user_id' => auth()->id(),
            'parent_id' => $this->replyingTo,
            'is_approved' => false,
        ]);

        $this->newComment = '';
        $this->replyingTo = null;
        $this->showCommentForm = false;

        session()->flash('success', 'Comment submitted successfully! It will appear after approval.');

        // Refresh the post with comments
        $this->post->refresh();
        $this->post->load(['approvedComments' => function ($query) {
            $query->with('user', 'approvedReplies.user')
                ->whereNull('parent_id')
                ->latest();
        }]);
    }

    public function replyTo($commentId)
    {
        if (!auth()->check()) {
            return redirect()->route('login');
        }

        $this->replyingTo = $commentId;
        $this->showCommentForm = true;
    }

    public function cancelReply()
    {
        $this->replyingTo = null;
        $this->newComment = '';
        $this->showCommentForm = false;
        $this->resetValidation();
    }

    public function render()
    {
        return view('livewire.comment-section');
    }
}
