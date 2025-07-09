<div class="mt-8">
    <!-- Comments Header -->
    <div class="flex justify-between items-center mb-6">
        <h3 class="text-2xl font-bold text-gray-900">
            Comments ({{ $post->approvedComments->count() }})
        </h3>

        @auth
        <button wire:click="toggleCommentForm"
            class="bg-blue-600 text-white px-4 py-2 rounded-md hover:bg-blue-700 transition-colors">
            {{ $showCommentForm ? 'Cancel' : 'Add Comment' }}
        </button>
        @else
        <a href="{{ route('login') }}"
            class="bg-blue-600 text-white px-4 py-2 rounded-md hover:bg-blue-700 transition-colors">
            Login to Comment
        </a>
        @endauth
    </div>

    <!-- Comment Form -->
    @if($showCommentForm)
    <div class="bg-gray-50 rounded-lg p-6 mb-6">
        @if($replyingTo)
        <div class="mb-4 p-3 bg-blue-50 border-l-4 border-blue-400">
            <div class="flex justify-between items-center">
                <span class="text-sm text-blue-700">Replying to comment</span>
                <button wire:click="cancelReply" class="text-blue-600 hover:text-blue-800">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                    </svg>
                </button>
            </div>
        </div>
        @endif

        <form wire:submit="submitComment">
            <div class="mb-4">
                <label for="newComment" class="block text-sm font-medium text-gray-700 mb-2">
                    Your Comment
                </label>
                <textarea wire:model="newComment"
                    id="newComment"
                    rows="4"
                    class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                    placeholder="Share your thoughts..."></textarea>
                @error('newComment')
                <span class="text-red-500 text-sm">{{ $message }}</span>
                @enderror
            </div>

            <div class="flex justify-end space-x-3">
                <button type="button"
                    wire:click="toggleCommentForm"
                    class="px-4 py-2 border border-gray-300 rounded-md text-sm font-medium text-gray-700 hover:bg-gray-50">
                    Cancel
                </button>
                <button type="submit"
                    class="px-4 py-2 bg-blue-600 border border-transparent rounded-md text-sm font-medium text-white hover:bg-blue-700">
                    Post Comment
                </button>
            </div>
        </form>
    </div>
    @endif

    <!-- Comments List -->
    <div class="space-y-6">
        @forelse($post->approvedComments as $comment)
        @livewire('comment-item', ['comment' => $comment], key($comment->id))
        @empty
        <div class="text-center py-8 text-gray-500">
            <div class="text-lg mb-2">No comments yet</div>
            <p>Be the first to share your thoughts!</p>
        </div>
        @endforelse
    </div>
</div>

@script
<script>
    $wire.on('reply-to-comment', (data) => {
        $wire.replyTo(data.commentId);
    });

    $wire.on('comment-deleted', () => {
        $wire.$refresh();
    });
</script>
@endscript