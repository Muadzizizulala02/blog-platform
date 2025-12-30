<x-app-layout>
    <x-slot name="title">Manage Posts</x-slot>

    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-100 leading-tight">
                Manage Posts
            </h2>
            {{-- Button to create new post --}}
            <a href="{{ route('admin.posts.create') }}" 
               class="px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded">
                Create New Post
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    @if($posts->count() > 0)
                        {{-- Table of posts --}}
                        <div class="overflow-x-auto">
                            <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                                <thead class="bg-gray-50 dark:bg-gray-700">
                                    <tr>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                            Title
                                        </th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                            Category
                                        </th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                            Author
                                        </th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                            Published
                                        </th>
                                        <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                            Actions
                                        </th>
                                    </tr>
                                </thead>
                                <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700">
                                    @foreach($posts as $post)
                                        <tr class="hover:bg-gray-100 dark:hover:bg-gray-700">
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                <div class="text-sm font-medium text-gray-900 dark:text-gray-100">
                                                    {{ $post->title }}
                                                </div>
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                <div class="text-sm text-gray-500 dark:text-gray-400">
                                                    {{ $post->category->name }}
                                                </div>
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                <div class="text-sm text-gray-500 dark:text-gray-400">
                                                    {{ $post->user->name }}
                                                </div>
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                <div class="text-sm text-gray-500 dark:text-gray-400">
                                                    {{ $post->published_at ? $post->published_at->format('M d, Y') : 'Draft' }}
                                                </div>
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                                {{-- View post --}}
                                                <a href="{{ route('blog.show', $post->slug) }}" 
                                                   class="text-blue-600 dark:text-blue-400 hover:text-blue-900 dark:hover:text-blue-300 mr-3"
                                                   target="_blank">
                                                    View
                                                </a>
                                                
                                                {{-- Edit post --}}
                                                <a href="{{ route('admin.posts.edit', $post) }}" 
                                                   class="text-indigo-600 dark:text-indigo-400 hover:text-indigo-900 dark:hover:text-indigo-300 mr-3">
                                                    Edit
                                                </a>
                                                
                                                {{-- Delete post --}}
                                                <form action="{{ route('admin.posts.destroy', $post) }}" 
                                                      method="POST" 
                                                      class="inline"
                                                      onsubmit="return confirm('Are you sure you want to delete this post?');">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" 
                                                            class="text-red-600 dark:text-red-400 hover:text-red-900 dark:hover:text-red-300">
                                                        Delete
                                                    </button>
                                                </form>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>

                        {{-- Pagination --}}
                        <div class="mt-4">
                            {{ $posts->links() }}
                        </div>
                    @else
                        <p class="text-gray-500 dark:text-gray-400">No posts found. Create your first post!</p>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>