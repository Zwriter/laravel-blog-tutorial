<div class="border-l-2 border-gray-200 pl-4" id="comment-{{ $comment->id }}">
    <div class="bg-white rounded-lg shadow-sm border p-4">
        <!-- Comment Header -->
        <div class="flex justify-between items-start mb-3">
            <div class="flex items-center space-x-3">
                <div class="w-8 h-8 bg-blue-600 rounded-full flex items-center justify-center text-white text-sm font-medium">
                    {{ substr($comment->user->name, 0, 1) }}
                </div>
                <div>
                    <div class="font-medium text-gray-900">{{ $comment->user->name }}</div>
                    <div class="text-xs text-gray-500">
                        {{ $comment->created_at->format('M j, Y \a\t g:i A') }}
                        @if($comment->updated_at->gt($comment->created_at))
                        <span class="ml-1 text-gray-400">(edited)</span>
                        @endif
                    </div>
                </div>
            </div>

            <!-- Comment Actions -->
            @auth
            @if(auth()->id() === $comment->user_id || auth()->user()->is_admin)
            <div class="flex space-x-2">
                @if(auth()->id() === $comment->user_id && !$isEditing)
                <button wire:click="startEditing"
                    class="text-gray-400 hover:text-gray-600">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                    </svg>
                </button>
                @endif

                <button wire:click="deleteComment"
                    wire:confirm="Are you sure you want to delete this comment?"
                    class="text-gray-400 hover:text-red-600">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                    </svg>
                </button>
            </div>
            @endif
            @endauth
        </div>

        <!-- Comment Content -->
        <div class="mb-3">
            @if($isEditing)
            <div class="space-y-3">
                <textarea wire:model="editContent"
                    rows="3"
                    class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"></textarea>
                @error('editContent')
                <span class="text-red-500 text-sm">{{ $message }}</span>
                @enderror

                <div class="flex justify-end space-x-2">
                    <button wire:click="cancelEditing"
                        class="px-3 py-1 text-sm border border-gray-300 rounded text-gray-700 hover:bg-gray-50">
                        Cancel
                    </button>
                    <button wire:click="saveEdit"
                        class="px-3 py-1 text-sm bg-blue-600 text-white rounded hover:bg-blue-700">
                        Save
                    </button>
                </div>
            </div>
            @else
            <div class="text-gray-900 leading-relaxed">
                {{ $comment->content }}
            </div>
            @endif
        </div>

        <!-- Comment Actions -->
        <div class="flex items-center space-x-4 text-sm">
            @auth
            <button wire:click="replyToComment"
                class="text-blue-600 hover:text-blue-800 font-medium">
                Reply
            </button>
            @endauth

            @if($comment->approvedReplies->count() > 0)
            <button wire:click="toggleReplies"
                class="text-gray-600 hover:text-gray-800 font-medium">
                {{ $showReplies ? 'Hide' : 'Show' }}
                {{ $comment->approvedReplies->count() }}
                {{ Str::plural('reply', $comment->approvedReplies->count()) }}
            </button>
            @endif
        </div>

        <!-- Replies -->
        @if($showReplies && $comment->approvedReplies->count() > 0)
        <div class="mt-4 space-y-4 ml-4">
            @foreach($comment->approvedReplies as $reply)
            @livewire('comment-item', ['comment' => $reply], key('reply-' . $reply->id))
            @endforeach
        </div>
        @endif
    </div>
</div>