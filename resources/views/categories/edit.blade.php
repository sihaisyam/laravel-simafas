<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Edit Category') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <form method="POST" action="{{ route('categories.update', $category->id) }}">
                        @csrf
                        @method('PUT')
                        <div class="mb-4">
                            <label for="name" class="block text-sm font-medium mb-2">Category Name</label>
                            <input type="text" id="name" name="name" value="{{ old('name', $category->name) }}" required
                                class="w-full px-3 py-2 border rounded-md dark:bg-gray-700 dark:border-gray-600">
                            @error('name')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                        <button type="submit"
                            class="px-4 py-2 bg-blue-500 text-white rounded-md hover:bg-blue-600">Update</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>