<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Edit Facility') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <form method="POST" action="{{ route('facilities.update', $facility->id) }}">
                        @csrf
                        @method('PUT')
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div class="mb-4">
                                <label for="name" class="block text-sm font-medium mb-2">Facility Name</label>
                                <input type="text" id="name" name="name" value="{{ old('name', $facility->name) }}" required
                                    class="w-full px-3 py-2 border rounded-md dark:bg-gray-700 dark:border-gray-600">
                                @error('name')
                                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <div class="mb-4">
                                <label for="category_id" class="block text-sm font-medium mb-2">Category</label>
                                <select id="category_id" name="category_id" required
                                    class="w-full px-3 py-2 border rounded-md dark:bg-gray-700 dark:border-gray-600">
                                    <option value="">Select Category</option>
                                    @foreach($categories as $category)
                                        <option value="{{ $category->id }}" {{ $facility->category_id == $category->id ? 'selected' : '' }}>
                                            {{ $category->name }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('category_id')
                                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <div class="mb-4">
                                <label for="capacity" class="block text-sm font-medium mb-2">Capacity</label>
                                <input type="number" id="capacity" name="capacity" value="{{ old('capacity', $facility->capacity) }}" required min="1"
                                    class="w-full px-3 py-2 border rounded-md dark:bg-gray-700 dark:border-gray-600">
                                @error('capacity')
                                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <div class="mb-4">
                                <label for="location" class="block text-sm font-medium mb-2">Location</label>
                                <input type="text" id="location" name="location" value="{{ old('location', $facility->location) }}" required
                                    class="w-full px-3 py-2 border rounded-md dark:bg-gray-700 dark:border-gray-600">
                                @error('location')
                                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <div class="mb-4">
                                <label for="hourly_rate" class="block text-sm font-medium mb-2">Hourly Rate (Rp)</label>
                                <input type="number" id="hourly_rate" name="hourly_rate" value="{{ old('hourly_rate', $facility->hourly_rate) }}" min="0" step="1000"
                                    class="w-full px-3 py-2 border rounded-md dark:bg-gray-700 dark:border-gray-600">
                                @error('hourly_rate')
                                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <div class="mb-4">
                                <label for="daily_rate" class="block text-sm font-medium mb-2">Daily Rate (Rp)</label>
                                <input type="number" id="daily_rate" name="daily_rate" value="{{ old('daily_rate', $facility->daily_rate) }}" min="0" step="1000"
                                    class="w-full px-3 py-2 border rounded-md dark:bg-gray-700 dark:border-gray-600">
                                @error('daily_rate')
                                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>

                        <div class="flex justify-between mt-6">
                            <a href="{{ route('facilities.index') }}"
                                class="px-4 py-2 bg-gray-500 text-white rounded-md hover:bg-gray-600">
                                Back to List
                            </a>
                            <div class="space-x-2">
                                <button type="reset"
                                    class="px-4 py-2 bg-yellow-500 text-white rounded-md hover:bg-yellow-600">
                                    Reset
                                </button>
                                <button type="submit"
                                    class="px-4 py-2 bg-blue-500 text-white rounded-md hover:bg-blue-600">
                                    Update Facility
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>