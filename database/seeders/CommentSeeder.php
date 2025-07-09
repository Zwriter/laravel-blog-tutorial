<?php

namespace Database\Seeders;

use App\Models\Comment;
use App\Models\Post;
use App\Models\User;
use Illuminate\Database\Seeder;

class CommentSeeder extends Seeder
{
    public function run(): void
    {
        $posts = Post::where('is_published', true)->get();
        $users = User::all();

        foreach ($posts as $post) {
            // Create parent comments
            $parentComments = Comment::factory(rand(2, 5))
                ->approved()
                ->create([
                    'post_id' => $post->id,
                    'user_id' => $users->random()->id,
                ]);

            // Create replies to some parent comments
            foreach ($parentComments as $parentComment) {
                if (rand(0, 100) < 40) { // 40% chance of having replies
                    Comment::factory(rand(1, 3))
                        ->approved()
                        ->create([
                            'post_id' => $post->id,
                            'user_id' => $users->random()->id,
                            'parent_id' => $parentComment->id,
                        ]);
                }
            }

            // Create some pending comments
            Comment::factory(rand(0, 2))
                ->pending()
                ->create([
                    'post_id' => $post->id,
                    'user_id' => $users->random()->id,
                ]);
        }
    }
}