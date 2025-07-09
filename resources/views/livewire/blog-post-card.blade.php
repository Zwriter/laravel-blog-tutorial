<article class="bg-white rounded-lg shadow-md overflow-hidden hover:shadow-lg transition-shadow">
    @if($post->featured_image)
        <img src="{{ $post->featured_image }}"
             alt="{{ $post->title }}"
             class="w-full h-48 object-cover">
    @endif

    <div class="p-6">
        <div class="flex items-center text-sm text-gray-500 mb-2">
            <span>{{ $post->user->name }}</span>
            <span class="mx-2">•</span>
            <time datetime="{{ $post->published_at->toISOString() }}">
                {{ $post->published_at->format('M j, Y') }}
            </time>
            @if($post->published_at->diffInDays() < 7)
                <span class="ml-2 inline-flex px-2 py-1 text-xs font-semibold rounded-full bg-blue-100 text-blue-800">
                    New
                </span>
            @endif
        </div>

        <h2 class="text-xl font-semibold text-gray-900 mb-3">
            <a href="{{ route('posts.show', $post) }}"
               class="hover:text-blue-600 transition-colors">
                {{ $post->title }}
            </a>
        </h2>

        <div class="text-gray-600 mb-4">
            @if($showFullContent && $post->content)
                <div class="prose max-w-none">
                    {!! Str::markdown($post->content) !!}
                </div>
            @elseif($post->excerpt)
                <p>{{ Str::limit($post->excerpt, 120) }}</p>
            @else
                <p>{{ Str::limit(strip_tags($post->content), 120) }}</p>
            @endif
        </div>

        <div class="flex items-center justify-between">
            <div class="flex space-x-4">
                <a href="{{ route('posts.show', $post) }}"
                   class="text-blue-600 hover:text-blue-800 font-medium transition-colors">
                    Read More →
                </a>

                @if($post->content && !$showFullContent)
                    <button wire:click="toggleContent"
                            class="text-gray-600 hover:text-gray-800 font-medium transition-colors">
                        Quick Preview
                    </button>
                @elseif($showFullContent)
                    <button wire:click="toggleContent"
                            class="text-gray-600 hover:text-gray-800 font-medium transition-colors">
                        Show Less
                    </button>
                @endif
            </div>

            <div class="flex items-center text-sm text-gray-500">
                <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                          d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z">
                    </path>
                </svg>
                {{ $post->approvedComments->count() }}
                {{ Str::plural('comment', $post->approvedComments->count()) }}
            </div>
        </div>
    </div>
</article>