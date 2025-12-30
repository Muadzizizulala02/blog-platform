<x-app-layout>
    <x-slot name="title">#{{ $tag->name }} - Posts</x-slot>

    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            Tag: #{{ $tag->name }}
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
                                           class="text-blue-600 dark:text-blue-400 hover:text-blue-800 dark:hover:text-blue-300 transition-colors">
                                            {{ $post->title }}
                                        </a>
                                    </h3>

                                    <div class="text-sm text-gray-600 dark:text-gray-400 mb-3">
                                        <span>By {{ $post->user->name }}</span>
                                        <span class="mx-2">•</span>
                                        <span>{{ $post->published_at->format('M d, Y') }}</span>
                                        <span class="mx-2">•</span>
                                        <a href="{{ route('blog.category', $post->category->slug) }}" 
                                           class="text-blue-500 dark:text-blue-400 hover:underline">
                                            {{ $post->category->name }}
                                        </a>
                                    </div>

                                    <p class="text-gray-700 dark:text-gray-300 mb-3">
                                        {{ Str::limit(strip_tags($post->content), 200) }}
                                    </p>

                                    <a href="{{ route('blog.show', $post->slug) }}" 
                                       class="text-blue-600 dark:text-blue-400 hover:text-blue-800 dark:hover:text-blue-300 font-semibold transition-colors">
                                        Read More →
                                    </a>
                                </article>
                            @endforeach
                        </div>

                        <div class="mt-6">
                            {{ $posts->links() }}
                        </div>
                    @else
                        <p class="text-gray-500 dark:text-gray-400">No posts with this tag yet.</p>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>