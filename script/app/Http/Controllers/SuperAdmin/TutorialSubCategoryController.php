<?php

namespace App\Http\Controllers\SuperAdmin;

use App\Http\Controllers\Controller;
use App\Models\TutorialCategory;
use App\Models\TutorialSubCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class TutorialSubCategoryController extends Controller
{
    public function index()
    {
        $subCategories = TutorialSubCategory::with('category')->withCount('tutorials')->latest()->paginate(10);
        return view('superadmin.tutorial-sub-categories.index', compact('subCategories'));
    }

    public function create()
    {
        $categories = TutorialCategory::all();
        return view('superadmin.tutorial-sub-categories.create', compact('categories'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'tutorial_category_id' => 'required|exists:tutorial_categories,id',
            'name' => 'required|string|max:255',
            'slug' => 'nullable|string|max:255|unique:tutorial_sub_categories,slug',
            'description' => 'nullable|string'
        ]);

        $slug = $request->slug ? Str::slug($request->slug) : Str::slug($request->name);

        TutorialSubCategory::create([
            'tutorial_category_id' => $request->tutorial_category_id,
            'name' => $request->name,
            'slug' => $slug,
            'description' => $request->description
        ]);

        return redirect()->route('superadmin.tutorial-sub-categories.index')
            ->with('success', 'Sub Category created successfully.');
    }

    public function edit(TutorialSubCategory $tutorialSubCategory)
    {
        $categories = TutorialCategory::all();
        return view('superadmin.tutorial-sub-categories.edit', compact('tutorialSubCategory', 'categories'));
    }

    public function update(Request $request, TutorialSubCategory $tutorialSubCategory)
    {
        $request->validate([
            'tutorial_category_id' => 'required|exists:tutorial_categories,id',
            'name' => 'required|string|max:255',
            'slug' => 'nullable|string|max:255|unique:tutorial_sub_categories,slug,' . $tutorialSubCategory->id,
            'description' => 'nullable|string'
        ]);

        $slug = $request->slug ? Str::slug($request->slug) : Str::slug($request->name);

        $tutorialSubCategory->update([
            'tutorial_category_id' => $request->tutorial_category_id,
            'name' => $request->name,
            'slug' => $slug,
            'description' => $request->description
        ]);

        return redirect()->route('superadmin.tutorial-sub-categories.index')
            ->with('success', 'Sub Category updated successfully.');
    }

    public function destroy(TutorialSubCategory $tutorialSubCategory)
    {
        $tutorialSubCategory->delete();
        return redirect()->route('superadmin.tutorial-sub-categories.index')
            ->with('success', 'Sub Category deleted successfully.');
    }

    public function getByCategory($categoryId)
    {
        $subCategories = TutorialSubCategory::where('tutorial_category_id', $categoryId)->get();
        return response()->json([
            'success' => true,
            'data' => $subCategories
        ]);
    }
}
