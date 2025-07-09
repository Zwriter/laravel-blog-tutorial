<div class="bg-gray-50 rounded-lg p-4">
    <form wire:submit="submit" class="space-y-4">
        <div>
            <label for="content" class="block text-sm font-medium text-gray-700 mb-2">
                {{ $isReply ? 'Your Reply' : 'Your Comment' }}
            </label>
            <textarea wire:model="content"
                id="content"
                rows="4"
                class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"
                placeholder="{{ $isReply ? 'Write your reply...' : 'Share your thoughts...' }}"></textarea>
            @error('content')
            <span class="text-red-500 text-sm">{{ $message }}</span>
            @enderror
        </div>

        <div class="flex justify-end space-x-3">
            @if($isReply)
            <button type="button"
                wire:click="$dispatch('cancel-reply')"
                class="px-4 py-2 border border-gray-300 rounded-md text-sm font-medium text-gray-700 hover:bg-gray-50">
                Cancel Reply
            </button>
            @endif
            <button type="submit"
                class="px-4 py-2 bg-blue-600 border border-transparent rounded-md text-sm font-medium text-white hover:bg-blue-700">
                {{ $isReply ? 'Post Reply' : 'Post Comment' }}
            </button>
        </div>
    </form>
</div>