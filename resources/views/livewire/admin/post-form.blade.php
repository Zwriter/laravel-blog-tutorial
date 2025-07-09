<form wire:submit="save" class="space-y-6">
    <div>
        <label for="title" class="block text-sm font-medium text-gray-700">Title</label>
        <input wire:model.live="title"
               type="text"
               id="title"
               class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500">
        @error('title') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
    </div>

    <div>
        <label for="slug" class="block text-sm font-medium text-gray-700">Slug</label>
        <div class="mt-1 flex rounded-md shadow-sm">
            <input wire:model="slug"
                   type="text"
                   id="slug"
                   class="flex-1 block w-full px-3 py-2 border border-gray-300 rounded-l-md focus:outline-none focus:ring-blue-500 focus:border-blue-500">
            <button type="button"
                    wire:click="generateSlug"
                    class="inline-flex items-center px-3 py-2 border border-l-0 border-gray-300 bg-gray-50 text-gray-500 rounded-r-md">
                Generate
            </button>
        </div>
        @error('slug') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
    </div>

    <div>
        <label for="excerpt" class="block text-sm font-medium text-gray-700">Excerpt</label>
        <textarea wire:model="excerpt"
                  id="excerpt"
                  rows="3"
                  class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500"
                  placeholder="Brief description of the post..."></textarea>
        @error('excerpt') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
    </div>

    <div>
        <label for="content" class="block text-sm font-medium text-gray-700">Content</label>
        <textarea wire:model="content"
                  id="content"
                  rows="10"
                  class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500"
                  placeholder="Write your post content here..."></textarea>
        @error('content') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
    </div>

    <div>
        <label for="featured_image" class="block text-sm font-medium text-gray-700">Featured Image URL</label>
        <input wire:model="featured_image"
               type="url"
               id="featured_image"
               class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500"
               placeholder="https://example.com/image.jpg">
        @error('featured_image') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
    </div>

    <div class="flex items-center">
        <input wire:model="is_published"
               type="checkbox"
               id="is_published"
               class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300 rounded">
        <label for="is_published" class="ml-2 block text-sm text-gray-900">
            Publish immediately
        </label>
    </div>

    <div class="flex justify-end space-x-3 pt-6 border-t">
        <button type="button"
                wire:click="$dispatch('close-form')"
                class="px-4 py-2 border border-gray-300 rounded-md text-sm font-medium text-gray-700 hover:bg-gray-50">
            Cancel
        </button>
        <button type="submit"
                class="px-4 py-2 bg-blue-600 border border-transparent rounded-md text-sm font-medium text-white hover:bg-blue-700">
            {{ $post ? 'Update Post' : 'Create Post' }}
        </button>
    </div>
</form>