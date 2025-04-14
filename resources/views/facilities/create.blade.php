<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Create New Facility') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <form method="POST" action="{{ route('facilities.store') }}">
                        @csrf
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div class="mb-4">
                                <label for="name" class="block text-sm font-medium mb-2">Facility Name</label>
                                <input type="text" id="name" name="name" required
                                    class="w-full px-3 py-2 border rounded-md dark:bg-gray-700 dark:border-gray-600">
                            </div>

                            <div class="mb-4">
                                <label for="category_id" class="block text-sm font-medium mb-2">Category</label>
                                <select id="category_id" name="category_id" required
                                    class="w-full px-3 py-2 border rounded-md dark:bg-gray-700 dark:border-gray-600">
                                    <option value="">Select Category</option>
                                    @foreach($categories as $category)
                                        <option value="{{ $category->id }}">{{ $category->name }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="mb-4">
                                <label for="capacity" class="block text-sm font-medium mb-2">Capacity</label>
                                <input type="number" id="capacity" name="capacity" required min="1"
                                    class="w-full px-3 py-2 border rounded-md dark:bg-gray-700 dark:border-gray-600">
                            </div>

                            <div class="mb-4">
                                <label for="location" class="block text-sm font-medium mb-2">Location</label>
                                <input type="text" id="location" name="location" required
                                    class="w-full px-3 py-2 border rounded-md dark:bg-gray-700 dark:border-gray-600">
                            </div>

                            <div class="mb-4">
                                <label for="hourly_rate" class="block text-sm font-medium mb-2">Hourly Rate (Rp)</label>
                                <input type="number" id="hourly_rate" name="hourly_rate" min="0" step="1000"
                                    class="w-full px-3 py-2 border rounded-md dark:bg-gray-700 dark:border-gray-600">
                            </div>

                            <div class="mb-4">
                                <label for="daily_rate" class="block text-sm font-medium mb-2">Daily Rate (Rp)</label>
                                <input type="number" id="daily_rate" name="daily_rate" min="0" step="1000"
                                    class="w-full px-3 py-2 border rounded-md dark:bg-gray-700 dark:border-gray-600">
                            </div>
                        </div>

                        <div class="flex justify-end mt-4">
                            <button type="submit"
                                class="px-4 py-2 bg-blue-500 text-white rounded-md hover:bg-blue-600">
                                Create Facility
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>