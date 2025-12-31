<x-app-layout>
    {{-- Set page title --}}
    <x-slot name="title">Blog - Latest Posts</x-slot>

    {{-- Page header --}}
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-100 ">
            Yo, {{ Auth::user()->name }}! 🤯 </h2>
    </x-slot>

    <div class="py-3">
        <div class="max-w-7xl mx-auto sm:px-1 lg:px-1">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">

                    {{-- Check if there are any posts --}}
                    @if ($posts->count() > 0)
                        <div class="space-y-6">
                            {{-- Loop through each post --}}
                            @foreach ($posts as $post)
                                <article class="border-b border-gray-200 dark:border-gray-700 pb-6 last:border-b-0">
                                    {{-- Post title as link --}}
                                    <h3 class="text-2xl font-bold mb-2">
                                        <a href="{{ route('blog.show', $post->slug) }}"
                                            class="text-blue-600 dark:text-blue-400 hover:text-blue-800 dark:hover:text-blue-300">
                                            {{ $post->title }}
                                        </a>
                                    </h3>

                                    {{-- Post metadata --}}
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

                                    {{-- Post excerpt (first 200 characters) --}}
                                    <p class="text-gray-700 dark:text-gray-300 mb-3">
                                        {{ Str::limit(strip_tags($post->content), 300) }}
                                    </p>

                                    {{-- Tags --}}
                                    @if ($post->tags->count() > 0)
                                        <div class="flex flex-wrap gap-2 mb-3">
                                            @foreach ($post->tags as $tag)
                                                <a href="{{ route('blog.tag', $tag->slug) }}"
                                                    class="bg-gray-200 dark:bg-gray-700 hover:bg-gray-300 dark:hover:bg-gray-600 text-gray-700 dark:text-gray-300 px-3 py-1 rounded-full text-sm">
                                                    #{{ $tag->name }}
                                                </a>
                                            @endforeach
                                        </div>
                                    @endif

                                    {{-- Read more link --}}
                                    <a href="{{ route('blog.show', $post->slug) }}"
                                        class="text-blue-600 dark:text-blue-400 hover:text-blue-800 dark:hover:text-blue-300 font-semibold">
                                        Read More →
                                    </a>
                                </article>
                            @endforeach
                        </div>

                        {{-- Pagination links --}}
                        <div class="mt-6">
                            {{ $posts->links() }}
                        </div>
                    @else
                        {{-- No posts message --}}
                        <p class="text-gray-500 dark:text-gray-400">No posts available yet.</p>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
