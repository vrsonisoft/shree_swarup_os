@extends('layouts.app')

@section('content')
<div class="p-6">
    <div class="flex justify-between items-center mb-6">
        <h2 class="text-2xl font-bold text-gray-800 dark:text-gray-200">Tutorials List</h2>
        <a href="{{ route('superadmin.tutorials.create') }}"
           class="inline-flex items-center px-4 py-2 bg-skin-base border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:opacity-80 focus:outline-none transition ease-in-out duration-150">
            + Add Tutorial
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
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Thumbnail</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Title</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Category</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Short Description</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Video</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200 dark:bg-gray-800 dark:divide-gray-700">
                        @forelse ($tutorials as $tutorial)
                            <tr>
                                <td class="px-6 py-4 whitespace-nowrap text-sm">
                                    @if ($tutorial->thumbnail)
                                        <img src="{{ asset('storage/' . $tutorial->thumbnail) }}" alt="Thumbnail" class="w-20 h-12 object-cover rounded border dark:border-gray-700">
                                    @else
                                        <div class="w-20 h-12 bg-gray-100 dark:bg-gray-700 rounded border dark:border-gray-600 flex items-center justify-center text-xs text-gray-400">No Image</div>
                                    @endif
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-semibold">{{ $tutorial->title }}</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm">
                                    <span class="px-2 py-1 inline-flex text-xs leading-5 font-semibold rounded-full bg-skin-base text-white">
                                        {{ $tutorial->category->name }}
                                    </span>
                                    @if($tutorial->subCategory)
                                        <div class="mt-1">
                                            <span class="px-2 py-0.5 inline-flex text-[11px] leading-4 font-medium rounded-full bg-emerald-100 dark:bg-emerald-900 text-emerald-800 dark:text-emerald-200">
                                                ↳ {{ $tutorial->subCategory->name }}
                                            </span>
                                        </div>
                                    @endif
                                </td>
                                <td class="px-6 py-4 text-sm text-gray-500 dark:text-gray-400 max-w-xs truncate">{{ $tutorial->short_description ?? '-' }}</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-400">
                                    @if ($tutorial->video_title)
                                        <div class="font-medium text-gray-900 dark:text-gray-200">{{ $tutorial->video_title }}</div>
                                        <div class="text-xs text-gray-400">{{ $tutorial->video_duration ?? 'N/A' }}</div>
                                    @else
                                        -
                                    @endif
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                    <div class="flex items-center gap-3">
                                        <a href="{{ route('superadmin.tutorials.edit', $tutorial->id) }}" class="text-skin-base hover:opacity-70 font-semibold">Edit</a>
                                        <form action="{{ route('superadmin.tutorials.destroy', $tutorial->id) }}" method="POST" onsubmit="return confirm('Are you sure?');" class="inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="text-red-600 dark:text-red-400 hover:text-red-900 font-semibold">Delete</button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="px-6 py-8 text-center text-sm text-gray-500 dark:text-gray-400">
                                    No tutorials found. Click <span class="text-skin-base font-semibold">+ Add Tutorial</span> to create one.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            <div class="mt-4">{{ $tutorials->links() }}</div>
        </div>
    </div>
</div>
@endsection
