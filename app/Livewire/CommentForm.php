<?php

namespace App\Livewire;

use App\Models\Post;
use Livewire\Component;

class CommentForm extends Component
{
    public Post $post;
    public $content = '';
    public $parentId = null;
    public $isReply = false;

    protected $rules = [
        'content' => 'required|string|max:1000|min:3',
    ];

    public function mount(Post $post, $parentId = null)
    {
        $this->post = $post;
        $this->parentId = $parentId;
        $this->isReply = !is_null($parentId);
    }

    public function submit()
    {
        if (!auth()->check()) {
            return redirect()->route('login');
        }

        $this->validate();

        $this->post->comments()->create([
            'content' => $this->content,
            'user_id' => auth()->id(),
            'parent_id' => $this->parentId,
            'is_approved' => false,
        ]);

        $this->content = '';
        session()->flash('success', 'Comment submitted successfully! It will appear after approval.');

        $this->dispatch('comment-submitted');
    }

    public function render()
    {
        return view('livewire.comment-form');
    }
}
