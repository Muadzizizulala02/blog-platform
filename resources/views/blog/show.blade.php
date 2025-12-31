<x-app-layout>
    {{-- Set page title to post title --}}
    <x-slot name="title">{{ $post->title }}</x-slot>

    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-100 leading-tight">
            {{ $post->title }}
        </h2>
    </x-slot>

    {{-- ✅ MATCHED: Updated py-3 and max-w-7xl to match your index page --}}
    <div class="py-3">
        <div class="max-w-7xl mx-auto sm:px-1 lg:px-1">
            
            {{-- Main post content --}}
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg mb-6">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    {{-- Post metadata --}}
                    <div class="text-sm text-gray-600 dark:text-gray-400 mb-4">
                        <span>By <strong>{{ $post->user->name }}</strong></span>
                        <span class="mx-2">•</span>
                        <span>{{ $post->published_at->format('F d, Y') }}</span>
                        <span class="mx-2">•</span>
                        <a href="{{ route('blog.category', $post->category->slug) }}" 
                           class="text-blue-500 dark:text-blue-400 hover:underline">
                            {{ $post->category->name }}
                        </a>
                    </div>

                    {{-- Tags --}}
                    @if($post->tags->count() > 0)
                        <div class="flex flex-wrap gap-2 mb-6">
                            @foreach($post->tags as $tag)
                                <a href="{{ route('blog.tag', $tag->slug) }}" 
                                   class="bg-blue-100 dark:bg-blue-900 hover:bg-blue-200 dark:hover:bg-blue-800 text-blue-700 dark:text-blue-300 px-3 py-1 rounded-full text-sm">
                                    #{{ $tag->name }}
                                </a>
                            @endforeach
                        </div>
                    @endif

                    {{-- Post content --}}
                    <div class="prose dark:prose-invert max-w-none mb-6">
                        {!! nl2br(e($post->content)) !!}
                    </div>

                    {{-- Like/Dislike buttons --}}
                    @auth
                        <div class="flex items-center gap-4 pt-4 border-t border-gray-200 dark:border-gray-700">
                            <form action="{{ route('posts.like', $post) }}" method="POST">
                                @csrf
                                <button type="submit" 
                                        class="flex items-center gap-2 px-4 py-2 bg-green-500 hover:bg-green-600 dark:bg-green-600 dark:hover:bg-green-700 text-white rounded">
                                    <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                                        <path d="M2 10.5a1.5 1.5 0 113 0v6a1.5 1.5 0 01-3 0v-6zM6 10.333v5.43a2 2 0 001.106 1.79l.05.025A4 4 0 008.943 18h5.416a2 2 0 001.962-1.608l1.2-6A2 2 0 0015.56 8H12V4a2 2 0 00-2-2 1 1 0 00-1 1v.667a4 4 0 01-.8 2.4L6.8 7.933a4 4 0 00-.8 2.4z"/>
                                    </svg>
                                    Like ({{ $post->likesCount() }})
                                </button>
                            </form>

                            <form action="{{ route('posts.dislike', $post) }}" method="POST">
                                @csrf
                                <button type="submit" 
                                        class="flex items-center gap-2 px-4 py-2 bg-red-500 hover:bg-red-600 dark:bg-red-600 dark:hover:bg-red-700 text-white rounded">
                                    <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                                        <path d="M18 9.5a1.5 1.5 0 11-3 0v-6a1.5 1.5 0 013 0v6zM14 9.667v-5.43a2 2 0 00-1.105-1.79l-.05-.025A4 4 0 0011.055 2H5.64a2 2 0 00-1.962 1.608l-1.2 6A2 2 0 004.44 12H8v4a2 2 0 002 2 1 1 0 001-1v-.667a4 4 0 01.8-2.4l1.4-1.866a4 4 0 00.8-2.4z"/>
                                    </svg>
                                    Dislike ({{ $post->dislikesCount() }})
                                </button>
                            </form>
                        </div>
                    @endauth
                </div>
            </div>

            {{-- Comments section --}}
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <h3 class="text-xl font-bold mb-4">
                        Comments ({{ $comments->count() }})
                    </h3>

                    @auth
                        <form action="{{ route('comments.store', $post) }}" method="POST" class="mb-6">
                            @csrf
                            <div class="mb-4">
                                <label for="content" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                    Leave a comment
                                </label>
                                <textarea 
                                    name="content" 
                                    id="content" 
                                    rows="4" 
                                    class="w-full border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100 rounded-md shadow-sm focus:border-blue-500 focus:ring-blue-500"
                                    required
                                    placeholder="Share your thoughts...">{{ old('content') }}</textarea>
                                
                                @error('content')
                                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <button type="submit" 
                                    class="px-4 py-2 bg-blue-600 hover:bg-blue-700 dark:bg-blue-700 dark:hover:bg-blue-800 text-white rounded">
                                Submit Comment
                            </button>
                        </form>
                    @else
                        <p class="mb-6 text-gray-600 dark:text-gray-400">
                            <a href="{{ route('login') }}" class="text-blue-600 dark:text-blue-400 hover:underline">Login</a> 
                            to leave a comment.
                        </p>
                    @endauth

                    @if($comments->count() > 0)
                        <div class="space-y-4">
                            @foreach($comments as $comment)
                                <div class="border-b border-gray-200 dark:border-gray-700 pb-4 last:border-b-0">
                                    <div class="flex items-start justify-between mb-2">
                                        <div>
                                            <p class="font-semibold">{{ $comment->user->name }}</p>
                                            <p class="text-sm text-gray-500 dark:text-gray-400">
                                                {{ $comment->created_at->diffForHumans() }}
                                            </p>
                                        </div>
                                        
                                        @auth
                                            @if(auth()->id() === $comment->user_id)
                                                <form action="{{ route('comments.destroy', $comment) }}" 
                                                      method="POST" 
                                                      onsubmit="return confirm('Delete this comment?');">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" 
                                                            class="text-red-600 dark:text-red-400 hover:text-red-800 dark:hover:text-red-300 text-sm">
                                                        Delete
                                                    </button>
                                                </form>
                                            @endif
                                        @endauth
                                    </div>
                                    <p class="text-gray-700 dark:text-gray-300">{{ $comment->content }}</p>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <p class="text-gray-600 dark:text-gray-400">No comments yet. Be the first to comment!</p>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>