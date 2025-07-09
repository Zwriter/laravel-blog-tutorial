<?php

namespace App\Livewire;

use App\Models\Comment;
use Livewire\Component;

class CommentItem extends Component
{
    public Comment $comment;
    public $showReplies = false;
    public $isEditing = false;
    public $editContent = '';

    protected $rules = [
        'editContent' => 'required|string|max:1000|min:3',
    ];

    public function mount(Comment $comment)
    {
        $this->comment = $comment;
        $this->editContent = $comment->content;
    }

    public function toggleReplies()
    {
        $this->showReplies = !$this->showReplies;
    }

    public function startEditing()
    {
        if (!auth()->check() || auth()->id() !== $this->comment->user_id) {
            return;
        }

        $this->isEditing = true;
        $this->editContent = $this->comment->content;
    }

    public function cancelEditing()
    {
        $this->isEditing = false;
        $this->editContent = $this->comment->content;
        $this->resetValidation();
    }

    public function saveEdit()
    {
        if (!auth()->check() || auth()->id() !== $this->comment->user_id) {
            return;
        }

        $this->validate();

        $this->comment->update([
            'content' => $this->editContent,
            'is_approved' => false, // Require re-approval after edit
        ]);

        $this->isEditing = false;
        session()->flash('success', 'Comment updated successfully! It will appear after approval.');
    }

    public function deleteComment()
    {
        if (!auth()->check() || (auth()->id() !== $this->comment->user_id && !auth()->user()->is_admin)) {
            return;
        }

        $this->comment->delete();
        session()->flash('success', 'Comment deleted successfully.');

        // Refresh parent component
        $this->dispatch('comment-deleted');
    }

    public function replyToComment()
    {
        $this->dispatch('reply-to-comment', commentId: $this->comment->id);
    }

    public function render()
    {
        return view('livewire.comment-item');
    }
}
