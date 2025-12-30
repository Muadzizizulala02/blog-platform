<x-app-layout>
    <x-slot name="title">{{ $category->name }} - Posts</x-slot>

    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            Category: {{ $category->name }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    @if($posts->count() > 0)
                        <div class="space-y-6">
                            @foreach($posts as $post)
                                <article class="border-b border-gray-200 dark:border-gray-700 pb-6 last:border-b-0">
                                    <h3 class="text-2xl font-bold mb-2">
                                        <a href="{{ route('blog.show', $post->slug) }}" 
                                           class="text-blue-600 dark:text-blue-400 hover:text-blue-800 dark:hover:text-blue-300">
                                            {{ $post->title }}
                                        </a>
                                    </h3>

                                    <div class="text-sm text-gray-600 dark:text-gray-400 mb-3">
                                        <span>By {{ $post->user->name }}</span>
                                        <span class="mx-2">•</span>
                                        <span>{{ $post->published_at->format('M d, Y') }}</span>
                                    </div>

                                    <p class="text-gray-700 dark:text-gray-300 mb-3">
                                        {{ Str::limit(strip_tags($post->content), 200) }}
                                    </p>

                                    @if($post->tags->count() > 0)
                                        <div class="flex flex-wrap gap-2 mb-3">
                                            @foreach($post->tags as $tag)
                                                <a href="{{ route('blog.tag', $tag->slug) }}" 
                                                   class="bg-gray-200 dark:bg-gray-700 hover:bg-gray-300 dark:hover:bg-gray-600 text-gray-700 dark:text-gray-300 px-3 py-1 rounded-full text-sm transition-colors">
                                                    #{{ $tag->name }}
                                                </a>
                                            @endforeach
                                        </div>
                                    @endif

                                    <a href="{{ route('blog.show', $post->slug) }}" 
                                       class="text-blue-600 dark:text-blue-400 hover:text-blue-800 dark:hover:text-blue-300 font-semibold inline-flex items-center">
                                        Read More 
                                        <svg class="w-4 h-4 ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"></path></svg>
                                    </a>
                                </article>
                            @endforeach
                        </div>

                        <div class="mt-6">
                            {{ $posts->links() }}
                        </div>
                    @else
                        <p class="text-gray-500 dark:text-gray-400">No posts in this category yet.</p>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>