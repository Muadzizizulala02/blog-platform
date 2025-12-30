<x-app-layout>
    <x-slot name="title">Create New Post</x-slot>

    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-100 leading-tight">
            Create New Post
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    {{-- Post creation form --}}
                    <form action="{{ route('admin.posts.store') }}" method="POST">
                        @csrf

                        {{-- Title field --}}
                        <div class="mb-4">
                            <label for="title" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                Post Title <span class="text-red-500">*</span>
                            </label>
                            <input 
                                type="text" 
                                name="title" 
                                id="title" 
                                value="{{ old('title') }}"
                                class="w-full border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-gray-100 rounded-md shadow-sm focus:border-blue-500 focus:ring-blue-500"
                                required>
                            @error('title')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        {{-- Category dropdown --}}
                        <div class="mb-4">
                            <label for="category_id" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                Category <span class="text-red-500">*</span>
                            </label>
                            <select 
                                name="category_id" 
                                id="category_id" 
                                class="w-full border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-gray-100 rounded-md shadow-sm focus:border-blue-500 focus:ring-blue-500"
                                required>
                                <option value="">Select a category</option>
                                @foreach($categories as $category)
                                    <option value="{{ $category->id }}" 
                                            {{ old('category_id') == $category->id ? 'selected' : '' }}>
                                        {{ $category->name }}
                                    </option>
                                @endforeach
                            </select>
                            @error('category_id')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        {{-- Tags multi-select --}}
                        <div class="mb-4">
                            <label for="tags" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                Tags (Hold Ctrl/Cmd to select multiple)
                            </label>
                            <select 
                                name="tags[]" 
                                id="tags" 
                                multiple
                                class="w-full border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-gray-100 rounded-md shadow-sm focus:border-blue-500 focus:ring-blue-500"
                                size="5">
                                @foreach($tags as $tag)
                                    <option value="{{ $tag->id }}"
                                            {{ in_array($tag->id, old('tags', [])) ? 'selected' : '' }}>
                                        {{ $tag->name }}
                                    </option>
                                @endforeach
                            </select>
                            @error('tags')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        {{-- Content textarea --}}
                        <div class="mb-4">
                            <label for="content" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                Content <span class="text-red-500">*</span>
                            </label>
                            <textarea 
                                name="content" 
                                id="content" 
                                rows="15"
                                class="w-full border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-gray-100 rounded-md shadow-sm focus:border-blue-500 focus:ring-blue-500"
                                required>{{ old('content') }}</textarea>
                            @error('content')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        {{-- Publish date --}}
                        <div class="mb-4">
                            <label for="published_at" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                Publish Date & Time
                            </label>
                            <input 
                                type="datetime-local" 
                                name="published_at" 
                                id="published_at" 
                                value="{{ old('published_at', now()->format('Y-m-d\TH:i')) }}"
                                class="w-full border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-gray-100 rounded-md shadow-sm focus:border-blue-500 focus:ring-blue-500">
                            @error('published_at')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                            <p class="text-sm text-gray-500 dark:text-gray-400 mt-1">Leave empty to publish immediately</p>
                        </div>

                        {{-- Submit buttons --}}
                        <div class="flex gap-4">
                            <button type="submit" 
                                    class="px-6 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded">
                                Create Post
                            </button>
                            <a href="{{ route('admin.posts.index') }}" 
                               class="px-6 py-2 bg-gray-300 dark:bg-gray-700 hover:bg-gray-400 dark:hover:bg-gray-600 text-gray-800 dark:text-gray-100 rounded">
                                Cancel
                            </a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>