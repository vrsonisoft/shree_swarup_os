@extends('layouts.app')

@section('content')
<div class="p-6">
    <div class="mb-6 flex items-center gap-3">
        <a href="{{ route('superadmin.tutorial-categories.index') }}" class="text-skin-base hover:opacity-70">
            ← Back
        </a>
        <h2 class="text-2xl font-bold text-gray-800 dark:text-gray-200">Edit Tutorial Category</h2>
    </div>

    <div class="max-w-3xl bg-white dark:bg-gray-800 overflow-hidden shadow-xl sm:rounded-lg">
        <div class="p-6">
            <form action="{{ route('superadmin.tutorial-categories.update', $tutorialCategory->id) }}" method="POST">
                @csrf
                @method('PUT')
                <div class="space-y-6">
                    <div>
                        <x-label for="name" value="Category Name" />
                        <x-input id="name" name="name" type="text" class="mt-1 block w-full" value="{{ old('name', $tutorialCategory->name) }}" required />
                        <x-input-error for="name" class="mt-2" />
                    </div>
                    <div>
                        <x-label for="slug" value="Slug (URL Friendly)" />
                        <x-input id="slug" name="slug" type="text" class="mt-1 block w-full" value="{{ old('slug', $tutorialCategory->slug) }}" required />
                        <x-input-error for="slug" class="mt-2" />
                    </div>
                    <div>
                        <x-label for="description" value="Description" />
                        <textarea id="description" name="description" rows="4"
                            class="mt-1 block w-full bg-white dark:bg-gray-800 text-gray-800 dark:text-gray-200 border-gray-300 dark:border-gray-700 focus:border-skin-base focus:ring-skin-base rounded-md shadow-sm">{{ old('description', $tutorialCategory->description) }}</textarea>
                        <x-input-error for="description" class="mt-2" />
                    </div>
                    <div class="flex items-center gap-4">
                        <button type="submit"
                            class="inline-flex items-center px-4 py-2 bg-skin-base border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:opacity-80 focus:outline-none transition ease-in-out duration-150">
                            Update Category
                        </button>
                        <a href="{{ route('superadmin.tutorial-categories.index') }}"
                            class="inline-flex items-center px-4 py-2 bg-gray-200 dark:bg-gray-700 border border-transparent rounded-md font-semibold text-xs text-gray-700 dark:text-gray-300 uppercase tracking-widest hover:bg-gray-300 dark:hover:bg-gray-600 transition ease-in-out duration-150">
                            Cancel
                        </a>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
