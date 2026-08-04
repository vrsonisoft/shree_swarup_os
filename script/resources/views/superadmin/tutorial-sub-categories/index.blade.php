@extends('layouts.app')

@section('content')
<div class="p-6">
    <div class="flex justify-between items-center mb-6">
        <h2 class="text-2xl font-bold text-gray-800 dark:text-gray-200">
            Tutorial Sub Categories
        </h2>
        <a href="{{ route('superadmin.tutorial-sub-categories.create') }}"
           class="inline-flex items-center px-4 py-2 bg-skin-base border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:opacity-80 focus:outline-none focus:ring-2 focus:ring-offset-2 transition ease-in-out duration-150">
            + Add Sub Category
        </a>
    </div>

    @if (session('success'))
        <div class="mb-4 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative" role="alert">
            <span class="block sm:inline">{{ session('success') }}</span>
        </div>
    @endif

    <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-xl sm:rounded-lg">
        <div class="p-6 text-gray-900 dark:text-gray-100">
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                    <thead class="bg-gray-50 dark:bg-gray-900">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Sub Category Name</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Main Category</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Slug</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Tutorials Count</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200 dark:bg-gray-800 dark:divide-gray-700">
                        @forelse ($subCategories as $subCategory)
                            <tr>
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-semibold">{{ $subCategory->name }}</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-400">
                                    <span class="px-2.5 py-1 rounded-full text-xs font-semibold bg-emerald-100 text-emerald-800 dark:bg-emerald-900 dark:text-emerald-200">
                                        {{ $subCategory->category ? $subCategory->category->name : 'N/A' }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-400">{{ $subCategory->slug }}</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-skin-base font-semibold">{{ $subCategory->tutorials_count }}</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                    <div class="flex items-center gap-3">
                                        <a href="{{ route('superadmin.tutorial-sub-categories.edit', $subCategory->id) }}" class="text-skin-base hover:opacity-70 font-semibold">Edit</a>
                                        <form action="{{ route('superadmin.tutorial-sub-categories.destroy', $subCategory->id) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this sub category?');" class="inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="text-red-600 dark:text-red-400 hover:text-red-900 font-semibold">Delete</button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="px-6 py-8 text-center text-sm text-gray-500 dark:text-gray-400">
                                    No sub categories found. Click <span class="text-skin-base font-semibold">+ Add Sub Category</span> to create one.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            <div class="mt-4">{{ $subCategories->links() }}</div>
        </div>
    </div>
</div>
@endsection
