<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;

class PostController extends Controller
{
    public function index()
    {
        $posts = Post::with('user')
            ->published()
            ->latest('published_at')
            ->paginate(6);

        return view('posts.index', compact('posts'));
    }

    public function show(Post $post)
    {
        if (!$post->is_published && (!auth()->check() || !auth()->user()->is_admin)) {
            abort(404);
        }

        $post->load([
            'user',
            'approvedComments' => function ($query) {
                $query->with('user', 'approvedReplies.user')
                      ->whereNull('parent_id')
                      ->latest();
            }
        ]);

        return view('posts.show', compact('post'));
    }
}