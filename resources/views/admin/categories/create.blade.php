<x-app-layout>
    <x-slot name="title">Create New Category</x-slot>

    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-100 leading-tight">
            Create New Category
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-2xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <form action="{{ route('admin.categories.store') }}" method="POST">
                        @csrf

                        {{-- Category name field --}}
                        <div class="mb-4">
                            <label for="name" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                Category Name <span class="text-red-500">*</span>
                            </label>
                            <input 
                                type="text" 
                                name="name" 
                                id="name" 
                                value="{{ old('name') }}"
                                class="w-full border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-gray-100 rounded-md shadow-sm focus:border-blue-500 focus:ring-blue-500"
                                placeholder="e.g., Technology, Travel, Food"
                                required>
                            @error('name')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                            <p class="text-sm text-gray-500 dark:text-gray-400 mt-1">Slug will be auto-generated from the name</p>
                        </div>

                        {{-- Submit buttons --}}
                        <div class="flex gap-4">
                            <button type="submit" 
                                    class="px-6 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded">
                                Create Category
                            </button>
                            <a href="{{ route('admin.categories.index') }}" 
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