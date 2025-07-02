@extends('layouts.blog')

@section('title', 'Laravel Blog Tutorial')
@section('description', 'Welcome to our Laravel blog tutorial. Learn Laravel and Livewire step by step.')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
    <!-- Hero Section -->
    <div class="text-center mb-12">
        <h1 class="text-4xl font-bold text-gray-900 mb-4">
            Welcome to Laravel Blog Tutorial
        </h1>
        <p class="text-xl text-gray-600 max-w-2xl mx-auto">
            Learn how to build a complete blog application with Laravel 11 and Livewire 3.
            Follow our step-by-step tutorials and master modern web development.
        </p>
    </div>

    <!-- Posts Grid -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
        @forelse($posts as $post)
        <article class="bg-white rounded-lg shadow-md overflow-hidden hover:shadow-lg transition-shadow">
            @if($post->featured_image)
            <img src="{{ $post->featured_image }}" alt="{{ $post->title }}"
                class="w-full h-48 object-cover">
            @endif

            <div class="p-6">
                <div class="flex items-center text-sm text-gray-500 mb-2">
                    <span>{{ $post->user->name }}</span>
                    <span class="mx-2">â€¢</span>
                    <time datetime="{{ $post->published_at->toISOString() }}">
                        {{ $post->published_at->format('M j, Y') }}
                    </time>
                </div>

                <h2 class="text-xl font-semibold text-gray-900 mb-3">
                    <a href="{{ route('posts.show', $post) }}" class="hover:text-blue-600">
                        {{ $post->title }}
                    </a>
                </h2>

                @if($post->excerpt)
                <p class="text-gray-600 mb-4">
                    {{ Str::limit($post->excerpt, 120) }}
                </p>
                @endif

                <div class="flex items-center justify-between">
                    <a href="{{ route('posts.show', $post) }}"
                        class="text-blue-600 hover:text-blue-800 font-medium">
                        Read More â†’
                    </a>

                    <span class="text-sm text-gray-500">
                        {{ $post->comments_count ?? $post->approvedComments->count() }} comments
                    </span>
                </div>
            </div>
        </article>
        @empty
        <div class="col-span-3 text-center py-12">
            <h3 class="text-lg font-medium text-gray-900 mb-2">No posts yet</h3>
            <p class="text-gray-600">Check back later for new content!</p>
        </div>
        @endforelse
    </div>

    <!-- Pagination -->
    @if($posts->hasPages())
    <div class="mt-12">
        {{ $posts->links() }}
    </div>
    @endif
</div>
@endsection