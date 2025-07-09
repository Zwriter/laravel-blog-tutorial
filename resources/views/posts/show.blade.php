@extends('layouts.blog')

@section('title', $post->title)
@section('description', Str::limit(strip_tags($post->excerpt ?: $post->content), 160))

@section('content')
<div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
    <article class="bg-white rounded-lg shadow-sm overflow-hidden">
        @if($post->featured_image)
        <img src="{{ $post->featured_image }}"
            alt="{{ $post->title }}"
            class="w-full h-64 md:h-96 object-cover">
        @endif

        <div class="p-8">
            <!-- Post Meta -->
            <div class="flex items-center text-sm text-gray-500 mb-4">
                <span>By {{ $post->user->name }}</span>
                <span class="mx-2">•</span>
                <time datetime="{{ $post->published_at->toISOString() }}">
                    {{ $post->published_at->format('F j, Y') }}
                </time>
                <span class="mx-2">•</span>
                <span>{{ $post->approvedComments->count() }} {{ Str::plural('comment', $post->approvedComments->count()) }}</span>
            </div>

            <!-- Post Title -->
            <h1 class="text-3xl md:text-4xl font-bold text-gray-900 mb-6">
                {{ $post->title }}
            </h1>

            <!-- Post Excerpt -->
            @if($post->excerpt)
            <div class="text-xl text-gray-600 leading-relaxed mb-6 font-medium">
                {{ $post->excerpt }}
            </div>
            @endif

            <!-- Post Content -->
            <div class="prose prose-lg max-w-none">
                {!! Str::markdown($post->content) !!}
            </div>
        </div>
    </article>

    <!-- Comment Section -->
    @livewire('comment-section', ['post' => $post])
</div>
@endsection