<?php

namespace App\Http\Controllers\SuperAdmin;

use App\Http\Controllers\Controller;
use App\Models\Tutorial;
use App\Models\TutorialCategory;
use App\Models\TutorialSubCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;

class TutorialController extends Controller
{
    public function index()
    {
        $tutorials = Tutorial::with(['category', 'subCategory'])->latest()->paginate(10);
        return view('superadmin.tutorials.index', compact('tutorials'));
    }

    public function create()
    {
        $categories = TutorialCategory::all();
        $subCategories = TutorialSubCategory::all();
        return view('superadmin.tutorials.create', compact('categories', 'subCategories'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'slug' => 'nullable|string|max:255|unique:tutorials,slug',
            'tutorial_category_id' => 'required|exists:tutorial_categories,id',
            'tutorial_sub_category_id' => 'nullable|exists:tutorial_sub_categories,id',
            'thumbnail' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg,webp|max:2048',
            'short_description' => 'nullable|string',
            'full_description' => 'nullable|string',
            'video_duration' => 'nullable|string|max:255',
            'video_title' => 'nullable|string|max:255',
            'youtube_url' => 'nullable|url|max:255'
        ]);

        $slug = $request->slug ? Str::slug($request->slug) : Str::slug($request->title);

        $thumbnailPath = null;
        if ($request->hasFile('thumbnail')) {
            $thumbnailPath = $request->file('thumbnail')->store('tutorials', 'public');
        }

        Tutorial::create([
            'title' => $request->title,
            'slug' => $slug,
            'tutorial_category_id' => $request->tutorial_category_id,
            'tutorial_sub_category_id' => $request->tutorial_sub_category_id,
            'thumbnail' => $thumbnailPath,
            'short_description' => $request->short_description,
            'full_description' => $request->full_description,
            'video_duration' => $request->video_duration,
            'video_title' => $request->video_title,
            'youtube_url' => $request->youtube_url
        ]);

        return redirect()->route('superadmin.tutorials.index')
            ->with('success', 'Tutorial created successfully.');
    }

    public function edit(Tutorial $tutorial)
    {
        $categories = TutorialCategory::all();
        $subCategories = TutorialSubCategory::where('tutorial_category_id', $tutorial->tutorial_category_id)->get();
        return view('superadmin.tutorials.edit', compact('tutorial', 'categories', 'subCategories'));
    }

    public function update(Request $request, Tutorial $tutorial)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'slug' => 'nullable|string|max:255|unique:tutorials,slug,' . $tutorial->id,
            'tutorial_category_id' => 'required|exists:tutorial_categories,id',
            'tutorial_sub_category_id' => 'nullable|exists:tutorial_sub_categories,id',
            'thumbnail' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg,webp|max:2048',
            'short_description' => 'nullable|string',
            'full_description' => 'nullable|string',
            'video_duration' => 'nullable|string|max:255',
            'video_title' => 'nullable|string|max:255',
            'youtube_url' => 'nullable|url|max:255'
        ]);

        $slug = $request->slug ? Str::slug($request->slug) : Str::slug($request->title);

        $data = [
            'title' => $request->title,
            'slug' => $slug,
            'tutorial_category_id' => $request->tutorial_category_id,
            'tutorial_sub_category_id' => $request->tutorial_sub_category_id,
            'short_description' => $request->short_description,
            'full_description' => $request->full_description,
            'video_duration' => $request->video_duration,
            'video_title' => $request->video_title,
            'youtube_url' => $request->youtube_url
        ];


        if ($request->hasFile('thumbnail')) {
            // Delete old thumbnail if exists
            if ($tutorial->thumbnail) {
                Storage::disk('public')->delete($tutorial->thumbnail);
            }
            $data['thumbnail'] = $request->file('thumbnail')->store('tutorials', 'public');
        }

        $tutorial->update($data);

        return redirect()->route('superadmin.tutorials.index')
            ->with('success', 'Tutorial updated successfully.');
    }

    public function destroy(Tutorial $tutorial)
    {
        if ($tutorial->thumbnail) {
            Storage::disk('public')->delete($tutorial->thumbnail);
        }
        $tutorial->delete();
        return redirect()->route('superadmin.tutorials.index')
            ->with('success', 'Tutorial deleted successfully.');
    }
}
