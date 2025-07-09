<?php

namespace App\Livewire\Admin;

use App\Models\Post;
use Livewire\Component;
use Illuminate\Support\Str;

class PostForm extends Component
{
    public $post;
    public $title = '';
    public $slug = '';
    public $excerpt = '';
    public $content = '';
    public $featured_image = '';
    public $is_published = false;

    protected $rules = [
        'title' => 'required|string|max:255',
        'slug' => 'nullable|string|max:255',
        'excerpt' => 'nullable|string|max:500',
        'content' => 'required|string',
        'featured_image' => 'nullable|url',
        'is_published' => 'boolean',
    ];

    protected $messages = [
        'title.required' => 'Please enter a title for your post.',
        'content.required' => 'Please enter some content for your post.',
        'featured_image.url' => 'Please enter a valid URL for the featured image.',
    ];

    public function mount($post = null)
    {
        if ($post) {
            $this->post = $post;
            $this->title = $post->title;
            $this->slug = $post->slug;
            $this->excerpt = $post->excerpt;
            $this->content = $post->content;
            $this->featured_image = $post->featured_image;
            $this->is_published = $post->is_published;
        }
    }

    public function updatedTitle()
    {
        if (empty($this->slug)) {
            $this->slug = Str::slug($this->title);
        }
    }

    public function generateSlug()
    {
        $this->slug = Str::slug($this->title);
    }

    public function save()
    {
        $this->validate();

        if (empty($this->slug)) {
            $this->slug = Str::slug($this->title);
        }

        $slugExists = Post::where('slug', $this->slug)
            ->when($this->post, fn($query) => $query->where('id', '!=', $this->post->id))
            ->exists();

        if ($slugExists) {
            $this->addError('slug', 'This slug is already taken.');
            return;
        }

        $data = [
            'title' => $this->title,
            'slug' => $this->slug,
            'excerpt' => $this->excerpt,
            'content' => $this->content,
            'featured_image' => $this->featured_image ?: null,
            'is_published' => $this->is_published,
        ];

        if ($this->is_published && (!$this->post || !$this->post->published_at)) {
            $data['published_at'] = now();
        } elseif (!$this->is_published) {
            $data['published_at'] = null;
        }

        if ($this->post) {
            $this->post->update($data);
            $message = 'Post updated successfully.';
        } else {
            $data['user_id'] = auth()->id();
            Post::create($data);
            $message = 'Post created successfully.';
        }

        session()->flash('success', $message);
        $this->dispatch('post-saved');
        $this->dispatch('close-form');
    }

    public function render()
    {
        return view('livewire.admin.post-form');
    }
}