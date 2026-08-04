@extends('layouts.app')

@section('content')
<div class="p-6">
    <div class="mb-6 flex items-center gap-3">
        <a href="{{ route('superadmin.tutorials.index') }}" class="text-skin-base hover:opacity-70">← Back</a>
        <h2 class="text-2xl font-bold text-gray-800 dark:text-gray-200">Add New Tutorial</h2>
    </div>

    @if ($errors->any())
        <div class="mb-4 bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative">
            <strong class="font-bold">Whoops!</strong>
            <ul class="mt-2 list-disc list-inside text-sm">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-xl sm:rounded-lg max-w-4xl">
        <div class="p-6">
            <form action="{{ route('superadmin.tutorials.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="space-y-6">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <x-label for="title" value="Tutorial Title" />
                            <x-input id="title" name="title" type="text" class="mt-1 block w-full" value="{{ old('title') }}" placeholder="e.g. How to Setup Restaurant Profile" required />
                            <x-input-error for="title" class="mt-2" />
                        </div>
                        <div>
                            <x-label for="tutorial_category_id" value="Category *" />
                            <select id="tutorial_category_id" name="tutorial_category_id"
                                class="mt-1 block w-full bg-white dark:bg-gray-800 text-gray-800 dark:text-gray-200 border-gray-300 dark:border-gray-700 focus:border-skin-base focus:ring-skin-base rounded-md shadow-sm" required onchange="filterSubCategories(this.value)">
                                <option value="" disabled selected>Select Category</option>
                                @foreach ($categories as $category)
                                    <option value="{{ $category->id }}" {{ old('tutorial_category_id') == $category->id ? 'selected' : '' }}>{{ $category->name }}</option>
                                @endforeach
                            </select>
                            <x-input-error for="tutorial_category_id" class="mt-2" />
                        </div>
                        <div>
                            <x-label for="tutorial_sub_category_id" value="Sub Category (Optional)" />
                            <select id="tutorial_sub_category_id" name="tutorial_sub_category_id"
                                class="mt-1 block w-full bg-white dark:bg-gray-800 text-gray-800 dark:text-gray-200 border-gray-300 dark:border-gray-700 focus:border-skin-base focus:ring-skin-base rounded-md shadow-sm">
                                <option value="">Select Sub Category</option>
                                @foreach ($subCategories as $subCat)
                                    <option value="{{ $subCat->id }}" data-category="{{ $subCat->tutorial_category_id }}" {{ old('tutorial_sub_category_id') == $subCat->id ? 'selected' : '' }}>
                                        {{ $subCat->name }}
                                    </option>
                                @endforeach
                            </select>
                            <x-input-error for="tutorial_sub_category_id" class="mt-2" />
                        </div>
                    </div>


                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <x-label for="slug" value="Slug (Optional)" />
                            <x-input id="slug" name="slug" type="text" class="mt-1 block w-full" value="{{ old('slug') }}" placeholder="e.g. how-to-setup" />
                            <x-input-error for="slug" class="mt-2" />
                        </div>
                        <div>
                            <x-label for="thumbnail" value="Thumbnail Image" />
                            <input id="thumbnail" name="thumbnail" type="file"
                                class="mt-1 block w-full text-sm text-gray-900 border border-gray-300 rounded-lg cursor-pointer bg-gray-50 dark:text-gray-400 dark:bg-gray-700 dark:border-gray-600"
                                accept="image/*" />
                            <x-input-error for="thumbnail" class="mt-2" />
                            <p class="text-xs text-gray-400 mt-1">Recommended: 16:9 ratio. Max 2MB.</p>
                        </div>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                        <div>
                            <x-label for="video_title" value="Video Title (Optional)" />
                            <x-input id="video_title" name="video_title" type="text" class="mt-1 block w-full" value="{{ old('video_title') }}" />
                            <x-input-error for="video_title" class="mt-2" />
                        </div>
                        <div>
                            <x-label for="video_duration" value="Video Duration (Optional)" />
                            <x-input id="video_duration" name="video_duration" type="text" class="mt-1 block w-full" value="{{ old('video_duration') }}" placeholder="e.g. 1:40" />
                            <x-input-error for="video_duration" class="mt-2" />
                        </div>
                        <div>
                            <x-label for="youtube_url" value="YouTube Video URL (Optional)" />
                            <x-input id="youtube_url" name="youtube_url" type="url" class="mt-1 block w-full" value="{{ old('youtube_url') }}" placeholder="https://www.youtube.com/watch?v=..." />
                            <x-input-error for="youtube_url" class="mt-2" />
                        </div>
                    </div>

                    <div>
                        <x-label for="short_description" value="Short Description" />
                        <textarea id="short_description" name="short_description" rows="3"
                            class="mt-1 block w-full bg-white dark:bg-gray-800 text-gray-800 dark:text-gray-200 border-gray-300 dark:border-gray-700 focus:border-skin-base focus:ring-skin-base rounded-md shadow-sm"
                            placeholder="Brief summary..." required>{{ old('short_description') }}</textarea>
                        <x-input-error for="short_description" class="mt-2" />
                    </div>

                    <div>
                        <x-label for="full_description" value="Full Description (Rich Text Editor)" />
                        <div class="mt-2">
                            <input id="full_description" name="full_description" type="hidden" value="{{ old('full_description') }}">
                            <trix-editor class="trix-content text-sm block mt-1 w-full bg-white dark:bg-gray-800 text-gray-800 dark:text-gray-200 border-gray-300 dark:border-gray-700 rounded-md shadow-sm min-h-[250px]" input="full_description"></trix-editor>
                        </div>
                        <x-input-error for="full_description" class="mt-2" />
                    </div>

                    <div class="flex items-center gap-4">
                        <button type="submit"
                            class="inline-flex items-center px-4 py-2 bg-skin-base border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:opacity-80 focus:outline-none transition ease-in-out duration-150">
                            Save Tutorial
                        </button>
                        <a href="{{ route('superadmin.tutorials.index') }}"
                            class="inline-flex items-center px-4 py-2 bg-gray-200 dark:bg-gray-700 border border-transparent rounded-md font-semibold text-xs text-gray-700 dark:text-gray-300 uppercase tracking-widest hover:bg-gray-300 dark:hover:bg-gray-600 transition ease-in-out duration-150">
                            Cancel
                        </a>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
function filterSubCategories(categoryId) {
    const subSelect = document.getElementById('tutorial_sub_category_id');
    if (!subSelect) return;
    const options = subSelect.querySelectorAll('option');
    options.forEach(opt => {
        if (!opt.value) return;
        const catId = opt.getAttribute('data-category');
        if (catId == categoryId) {
            opt.style.display = 'block';
            opt.disabled = false;
        } else {
            opt.style.display = 'none';
            opt.disabled = true;
        }
    });
    const selected = subSelect.options[subSelect.selectedIndex];
    if (selected && selected.disabled) {
        subSelect.value = '';
    }
}
document.addEventListener('DOMContentLoaded', () => {
    const catSelect = document.getElementById('tutorial_category_id');
    if (catSelect && catSelect.value) {
        filterSubCategories(catSelect.value);
    }
});
</script>
@endsection

