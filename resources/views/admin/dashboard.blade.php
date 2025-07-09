<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Admin Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-8">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 text-center">
                        <div class="text-3xl font-bold text-blue-600">
                            {{ \App\Models\Post::count() }}
                        </div>
                        <div class="text-gray-600">Total Posts</div>
                    </div>
                </div>

                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 text-center">
                        <div class="text-3xl font-bold text-green-600">
                            {{ \App\Models\Post::where('is_published', true)->count() }}
                        </div>
                        <div class="text-gray-600">Published</div>
                    </div>
                </div>

                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 text-center">
                        <div class="text-3xl font-bold text-yellow-600">
                            {{ \App\Models\Comment::where('is_approved', false)->count() }}
                        </div>
                        <div class="text-gray-600">Pending Comments</div>
                    </div>
                </div>

                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 text-center">
                        <div class="text-3xl font-bold text-purple-600">
                            {{ \App\Models\User::count() }}
                        </div>
                        <div class="text-gray-600">Total Users</div>
                    </div>
                </div>
            </div>

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mb-8">
                <div class="p-6">
                    <h3 class="text-lg font-medium text-gray-900 mb-4">Quick Actions</h3>
                    <div class="flex flex-wrap gap-4">
                        <a href="{{ route('admin.posts.index') }}"
                           class="bg-blue-600 text-white px-4 py-2 rounded-md hover:bg-blue-700">
                            Manage Posts
                        </a>
                        <a href="{{ route('admin.comments.index') }}"
                           class="bg-green-600 text-white px-4 py-2 rounded-md hover:bg-green-700">
                            Manage Comments
                        </a>
                        <a href="{{ route('home') }}"
                           class="bg-gray-600 text-white px-4 py-2 rounded-md hover:bg-gray-700">
                            View Blog
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>