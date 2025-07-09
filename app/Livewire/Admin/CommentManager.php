<?php

namespace App\Livewire\Admin;

use App\Models\Comment;
use App\Models\Post;
use Livewire\Component;
use Livewire\WithPagination;

class CommentManager extends Component
{
    use WithPagination;

    public $search = '';
    public $filter = 'all';
    public $postFilter = '';

    protected $queryString = [
        'search' => ['except' => ''],
        'filter' => ['except' => 'all'],
        'postFilter' => ['except' => ''],
    ];

    public function mount()
    {
        if (!auth()->user()->is_admin) {
            abort(403);
        }
    }

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function updatingFilter()
    {
        $this->resetPage();
    }

    public function updatingPostFilter()
    {
        $this->resetPage();
    }

    public function approveComment(Comment $comment)
    {
        $comment->update(['is_approved' => !$comment->is_approved]);

        $status = $comment->is_approved ? 'approved' : 'unapproved';
        session()->flash('success', "Comment {$status} successfully.");
    }

    public function deleteComment(Comment $comment)
    {
        $comment->delete();
        session()->flash('success', 'Comment deleted successfully.');
    }

    public function render()
    {
        $query = Comment::with(['user', 'post']);

        if ($this->search) {
            $query->where('content', 'like', '%' . $this->search . '%')
                ->orWhereHas('user', function ($q) {
                    $q->where('name', 'like', '%' . $this->search . '%');
                });
        }

        switch ($this->filter) {
            case 'approved':
                $query->where('is_approved', true);
                break;
            case 'pending':
                $query->where('is_approved', false);
                break;
            case 'replies':
                $query->whereNotNull('parent_id');
                break;
        }

        if ($this->postFilter) {
            $query->where('post_id', $this->postFilter);
        }

        $comments = $query->latest()->paginate(15);
        $posts = Post::orderBy('title')->get();

        return view('livewire.admin.comment-manager', compact('comments', 'posts'));
    }
}
