@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-8">
    <!-- Header with Back Button -->
    <div class="flex items-center justify-between mb-6">
        <h1 class="text-3xl font-bold text-gray-900 dark:text-gray-100">{{ $post->title }}</h1>
        <a href="{{ route('admin.posts.index') }}" class="text-blue-600 dark:text-blue-400 hover:text-blue-800 dark:hover:text-blue-300">
            ← Back to Posts
        </a>
    </div>

    <!-- Post Details Card -->
    <div class="bg-white dark:bg-gray-800 rounded-lg shadow-md p-6 mb-6">
        <!-- Meta Information -->
        <div class="flex flex-wrap gap-4 text-sm text-gray-600 dark:text-gray-400 mb-4">
            <div>
                <span class="font-semibold">Author:</span>
                <span>{{ $post->user->name }}</span>
            </div>
            <div>
                <span class="font-semibold">Category:</span>
                <span>{{ $post->category->name }}</span>
            </div>
            <div>
                <span class="font-semibold">Created:</span>
                <span>{{ $post->created_at->format('M d, Y') }}</span>
            </div>
            <div>
                <span class="font-semibold">Published:</span>
                <span>{{ $post->published_at?->format('M d, Y') ?? 'Not published' }}</span>
            </div>
        </div>

        <!-- Tags -->
        @if($post->tags->count() > 0)
        <div class="mb-4">
            <span class="font-semibold text-sm text-gray-700 dark:text-gray-300">Tags:</span>
            <div class="flex flex-wrap gap-2 mt-2">
                @foreach($post->tags as $tag)
                <span class="bg-blue-100 dark:bg-blue-900 text-blue-800 dark:text-blue-200 text-xs px-3 py-1 rounded-full">
                    {{ $tag->name }}
                </span>
                @endforeach
            </div>
        </div>
        @endif

        <!-- Post Content -->
        <div class="border-t border-gray-200 dark:border-gray-700 pt-6 mb-6">
            <div class="prose dark:prose-invert max-w-none text-gray-800 dark:text-gray-300">
                {!! nl2br(e($post->content)) !!}
            </div>
        </div>

        <!-- Action Buttons -->
        <div class="flex gap-4 border-t border-gray-200 dark:border-gray-700 pt-6">
            <a href="{{ route('admin.posts.edit', $post) }}" class="bg-yellow-500 hover:bg-yellow-600 text-white font-bold py-2 px-4 rounded">
                Edit
            </a>
            <form action="{{ route('admin.posts.destroy', $post) }}" method="POST" onsubmit="return confirm('Are you sure?');">
                @csrf
                @method('DELETE')
                <button type="submit" class="bg-red-500 hover:bg-red-600 text-white font-bold py-2 px-4 rounded">
                    Delete
                </button>
            </form>
        </div>
    </div>

    <!-- Comments Section -->
    <div class="bg-white dark:bg-gray-800 rounded-lg shadow-md p-6">
        <h2 class="text-2xl font-bold text-gray-900 dark:text-gray-100 mb-6">Comments ({{ $post->comments->count() }})</h2>

        @if($post->comments->count() > 0)
            <div class="space-y-4">
                @foreach($post->comments as $comment)
                <div class="border-l-4 border-blue-500 bg-gray-50 dark:bg-gray-700 p-4">
                    <div class="flex justify-between items-start mb-2">
                        <div>
                            <p class="font-semibold text-gray-900 dark:text-gray-100">{{ $comment->user->name }}</p>
                            <p class="text-sm text-gray-600 dark:text-gray-400">{{ $comment->created_at->format('M d, Y H:i') }}</p>
                        </div>
                        <span class="px-2 py-1 text-xs rounded {{ $comment->status === 'approved' ? 'bg-green-100 dark:bg-green-900 text-green-800 dark:text-green-100' : 'bg-yellow-100 dark:bg-yellow-900 text-yellow-800 dark:text-yellow-100' }}">
                            {{ ucfirst($comment->status) }}
                        </span>
                    </div>
                    <p class="text-gray-800 dark:text-gray-300">{{ $comment->content }}</p>
                </div>
                @endforeach
            </div>
        @else
            <p class="text-gray-600 dark:text-gray-400 text-center py-8">No comments yet.</p>
        @endif
    </div>
</div>
@endsection
