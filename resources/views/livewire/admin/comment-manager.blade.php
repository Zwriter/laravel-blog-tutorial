<div class="space-y-6">
    <!-- Header -->
    <div class="flex justify-between items-center">
        <h1 class="text-2xl font-bold text-gray-900">Manage Comments</h1>
        <div class="text-sm text-gray-600">
            {{ $comments->total() }} total comments
        </div>
    </div>

    <!-- Filters -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
        <div>
            <input wire:model.live.debounce.300ms="search"
                type="text"
                placeholder="Search comments or authors..."
                class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
        </div>

        <select wire:model.live="filter"
            class="px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
            <option value="all">All Comments</option>
            <option value="approved">Approved</option>
            <option value="pending">Pending Approval</option>
            <option value="replies">Replies Only</option>
        </select>

        <select wire:model.live="postFilter"
            class="px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
            <option value="">All Posts</option>
            @foreach($posts as $post)
            <option value="{{ $post->id }}">{{ Str::limit($post->title, 40) }}</option>
            @endforeach
        </select>
    </div>

    <!-- Comments List -->
    <div class="bg-white rounded-lg shadow overflow-hidden">
        <div class="space-y-4 p-6">
            @forelse($comments as $comment)
            <div class="border border-gray-200 rounded-lg p-4">
                <div class="flex justify-between items-start mb-3">
                    <div class="flex items-center space-x-3">
                        <div class="font-medium text-gray-900">
                            {{ $comment->user->name }}
                        </div>
                        <div class="text-sm text-gray-500">
                            {{ $comment->created_at->format('M j, Y \a\t g:i A') }}
                        </div>
                        @if($comment->parent_id)
                        <span class="inline-flex px-2 py-1 text-xs font-semibold rounded-full bg-blue-100 text-blue-800">
                            Reply
                        </span>
                        @endif
                        @if($comment->is_approved)
                        <span class="inline-flex px-2 py-1 text-xs font-semibold rounded-full bg-green-100 text-green-800">
                            Approved
                        </span>
                        @else
                        <span class="inline-flex px-2 py-1 text-xs font-semibold rounded-full bg-yellow-100 text-yellow-800">
                            Pending
                        </span>
                        @endif
                    </div>
                </div>

                <div class="mb-3">
                    <div class="text-sm text-gray-600 mb-2">
                        On post:
                        <a href="{{ route('posts.show', $comment->post) }}"
                            target="_blank"
                            class="text-blue-600 hover:text-blue-800">
                            {{ $comment->post->title }}
                        </a>
                    </div>
                    <div class="text-gray-900">
                        {{ $comment->content }}
                    </div>
                </div>

                <div class="flex items-center justify-between">
                    <div class="flex space-x-3">
                        <button wire:click="approveComment({{ $comment->id }})"
                            class="text-{{ $comment->is_approved ? 'yellow' : 'green' }}-600 hover:text-{{ $comment->is_approved ? 'yellow' : 'green' }}-800 text-sm">
                            {{ $comment->is_approved ? 'Unapprove' : 'Approve' }}
                        </button>

                        <a href="{{ route('posts.show', $comment->post) }}#comment-{{ $comment->id }}"
                            target="_blank"
                            class="text-blue-600 hover:text-blue-800 text-sm">
                            View in Context
                        </a>
                    </div>

                    <button wire:click="deleteComment({{ $comment->id }})"
                        wire:confirm="Are you sure you want to delete this comment?"
                        class="text-red-600 hover:text-red-800 text-sm">
                        Delete
                    </button>
                </div>
            </div>
            @empty
            <div class="text-center py-8 text-gray-500">
                No comments found.
            </div>
            @endforelse
        </div>
    </div>

    <!-- Pagination -->
    @if($comments->hasPages())
    <div class="mt-6">
        {{ $comments->links() }}
    </div>
    @endif
</div>