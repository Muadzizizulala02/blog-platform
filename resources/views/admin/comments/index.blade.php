<x-app-layout>
    <x-slot name="title">Moderate Comments</x-slot>

    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-100 leading-tight">
            Moderate Comments
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    @if($comments->count() > 0)
                        <div class="space-y-4">
                            @foreach($comments as $comment)
                                <div class="border rounded-lg p-4 dark:border-gray-600 {{ 
                                    $comment->status === 'pending' ? 'bg-yellow-50 dark:bg-yellow-900 dark:bg-opacity-20 border-yellow-300 dark:border-yellow-600' : 
                                    ($comment->status === 'approved' ? 'bg-green-50 dark:bg-green-900 dark:bg-opacity-20 border-green-300 dark:border-green-600' : 'bg-red-50 dark:bg-red-900 dark:bg-opacity-20 border-red-300 dark:border-red-600') 
                                }}">
                                    {{-- Comment header --}}
                                    <div class="flex justify-between items-start mb-2">
                                        <div>
                                            <p class="font-semibold text-gray-900 dark:text-gray-100">
                                                {{ $comment->user->name }}
                                            </p>
                                            <p class="text-sm text-gray-600 dark:text-gray-400">
                                                On: <a href="{{ route('blog.show', $comment->post->slug) }}" 
                                                       class="text-blue-600 dark:text-blue-400 hover:underline"
                                                       target="_blank">
                                                    {{ $comment->post->title }}
                                                </a>
                                            </p>
                                            <p class="text-xs text-gray-500 dark:text-gray-400">
                                                {{ $comment->created_at->diffForHumans() }}
                                            </p>
                                        </div>
                                        
                                        {{-- Status badge --}}
                                        <span class="px-3 py-1 text-xs font-semibold rounded-full {{
                                            $comment->status === 'pending' ? 'bg-yellow-200 dark:bg-yellow-700 text-yellow-800 dark:text-yellow-100' :
                                            ($comment->status === 'approved' ? 'bg-green-200 dark:bg-green-700 text-green-800 dark:text-green-100' : 'bg-red-200 dark:bg-red-700 text-red-800 dark:text-red-100')
                                        }}">
                                            {{ ucfirst($comment->status) }}
                                        </span>
                                    </div>

                                    {{-- Comment content --}}
                                    <p class="text-gray-700 dark:text-gray-300 mb-3">
                                        {{ $comment->content }}
                                    </p>

                                    {{-- Action buttons --}}
                                    <div class="flex gap-2">
                                        @if($comment->status !== 'approved')
                                            <form action="{{ route('admin.comments.approve', $comment) }}" 
                                                  method="POST">
                                                @csrf
                                                <button type="submit" 
                                                        class="px-4 py-2 bg-green-600 hover:bg-green-700 dark:bg-green-700 dark:hover:bg-green-600 text-white text-sm rounded">
                                                    Approve
                                                </button>
                                            </form>
                                        @endif

                                        @if($comment->status !== 'rejected')
                                            <form action="{{ route('admin.comments.reject', $comment) }}" 
                                                  method="POST">
                                                @csrf
                                                <button type="submit" 
                                                        class="px-4 py-2 bg-yellow-600 hover:bg-yellow-700 dark:bg-yellow-700 dark:hover:bg-yellow-600 text-white text-sm rounded">
                                                    Reject
                                                </button>
                                            </form>
                                        @endif

                                        <form action="{{ route('admin.comments.destroy', $comment) }}" 
                                              method="POST"
                                              onsubmit="return confirm('Permanently delete this comment?');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" 
                                                    class="px-4 py-2 bg-red-600 hover:bg-red-700 dark:bg-red-700 dark:hover:bg-red-600 text-white text-sm rounded">
                                                Delete
                                            </button>
                                        </form>
                                    </div>
                                </div>
                            @endforeach
                        </div>

                        {{-- Pagination --}}
                        <div class="mt-6">
                            {{ $comments->links() }}
                        </div>
                    @else
                        <p class="text-gray-500 dark:text-gray-400">No comments to moderate.</p>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>