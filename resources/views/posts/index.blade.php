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
            Learn how to build a complete blog application with Laravel 12 and Livewire 3.
            Follow our step-by-step tutorials and master modern web development.
        </p>
    </div>

    <!-- Posts Grid -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
        @forelse($posts as $post)
            @livewire('blog-post-card', ['post' => $post], key($post->id))
        @empty
            <div class="col-span-3 text-center py-12">
                <h3 class="text-lg font-medium text-gray-900 mb-2">No posts yet</h3>
                <p class="text-gray-600">Check back later for new content!</p>
                @auth
                    @if(auth()->user()->is_admin)
                        <a href="{{ route('admin.posts.index') }}" class="mt-4 inline-block bg-blue-600 text-white px-4 py-2 rounded-md hover:bg-blue-700">
                            Manage Posts
                        </a>
                    @endif
                @endauth
            </div>
        @endforelse
    </div>

    <!-- Pagination -->
    @if($posts->hasPages())
        <div class="mt-12">
            {{ $posts->links() }}
        </div>
    @endif

    <!-- Day 4 Features Notice -->
    <div class="mt-16 bg-green-50 border border-green-200 rounded-lg p-6">
        <h3 class="text-lg font-semibold text-green-900 mb-3">🎉 Day 4 Implementation Complete!</h3>
        <p class="text-green-800 mb-4"><strong>New Livewire features implemented:</strong></p>
        <ul class="text-green-700 space-y-1 mb-4">
            <li>✅ Interactive Livewire components for blog post management</li>
            <li>✅ Real-time CRUD operations with modal forms</li>
            <li>✅ Form validation and error handling</li>
            <li>✅ Interactive admin dashboard with live stats</li>
            <li>✅ BlogPostCard component with quick preview</li>
            <li>✅ Search and filter functionality</li>
        </ul>
        <p class="text-green-800"><strong>Next:</strong> Day 5 will implement Livewire components for comment management and nested replies.</p>
    </div>
</div>
@endsection