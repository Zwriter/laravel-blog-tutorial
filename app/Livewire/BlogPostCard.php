<?php

namespace App\Livewire;

use App\Models\Post;
use Livewire\Component;

class BlogPostCard extends Component
{
    public Post $post;
    public $showFullContent = false;

    public function mount(Post $post)
    {
        $this->post = $post;
    }

    public function toggleContent()
    {
        $this->showFullContent = !$this->showFullContent;
    }

    public function render()
    {
        return view('livewire.blog-post-card');
    }
}