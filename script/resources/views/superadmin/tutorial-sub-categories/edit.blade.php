@extends('layouts.app')

@section('content')
<div class="p-6">
    <div class="flex justify-between items-center mb-6">
        <h2 class="text-2xl font-bold text-gray-800 dark:text-gray-200">
            Edit Tutorial Sub Category
        </h2>
        <a href="{{ route('superadmin.tutorial-sub-categories.index') }}"
           class="inline-flex items-center px-4 py-2 bg-gray-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 focus:outline-none transition ease-in-out duration-150">
            Back to List
        </a>
    </div>

    <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-xl sm:rounded-lg">
        <div class="p-6 text-gray-900 dark:text-gray-100">
            <form action="{{ route('superadmin.tutorial-sub-categories.update', $tutorialSubCategory->id) }}" method="POST" class="space-y-6">
                @csrf
                @method('PUT')

                <div>
                    <label for="tutorial_category_id" class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                        Main Category <span class="text-red-500">*</span>
                    </label>
                    <select name="tutorial_category_id" id="tutorial_category_id" required
                            class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 shadow-sm focus:border-skin-base focus:ring-skin-base">
                        <option value="">Select Main Category</option>
                        @foreach ($categories as $category)
                            <option value="{{ $category->id }}" {{ old('tutorial_category_id', $tutorialSubCategory->tutorial_category_id) == $category->id ? 'selected' : '' }}>
                                {{ $category->name }}
                            </option>
                        @endforeach
                    </select>
                    @error('tutorial_category_id')
                        <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="name" class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                        Sub Category Name <span class="text-red-500">*</span>
                    </label>
                    <input type="text" name="name" id="name" value="{{ old('name', $tutorialSubCategory->name) }}" required
                           class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 shadow-sm focus:border-skin-base focus:ring-skin-base">
                    @error('name')
                        <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="slug" class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                        Slug (Optional)
                    </label>
                    <input type="text" name="slug" id="slug" value="{{ old('slug', $tutorialSubCategory->slug) }}"
                           class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 shadow-sm focus:border-skin-base focus:ring-skin-base">
                    @error('slug')
                        <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="description" class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                        Description (Optional)
                    </label>
                    <textarea name="description" id="description" rows="4"
                              class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 shadow-sm focus:border-skin-base focus:ring-skin-base">{{ old('description', $tutorialSubCategory->description) }}</textarea>
                    @error('description')
                        <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                    @enderror
                </div>

                <div class="flex justify-end gap-3 pt-4">
                    <a href="{{ route('superadmin.tutorial-sub-categories.index') }}"
                       class="px-4 py-2 bg-gray-200 dark:bg-gray-700 text-gray-800 dark:text-gray-200 rounded-md font-semibold text-xs uppercase tracking-widest hover:bg-gray-300 transition">
                        Cancel
                    </a>
                    <button type="submit"
                            class="px-4 py-2 bg-skin-base text-white rounded-md font-semibold text-xs uppercase tracking-widest hover:opacity-80 transition">
                        Update Sub Category
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
