<?php

namespace App\Http\Controllers\SuperAdmin;

use App\Http\Controllers\Controller;
use App\Models\TutorialCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class TutorialCategoryController extends Controller
{
    public function index()
    {
        $categories = TutorialCategory::withCount('tutorials')->latest()->paginate(10);
        return view('superadmin.tutorial-categories.index', compact('categories'));
    }

    public function create()
    {
        return view('superadmin.tutorial-categories.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'slug' => 'nullable|string|max:255|unique:tutorial_categories,slug',
            'description' => 'nullable|string'
        ]);

        $slug = $request->slug ? Str::slug($request->slug) : Str::slug($request->name);

        TutorialCategory::create([
            'name' => $request->name,
            'slug' => $slug,
            'description' => $request->description
        ]);

        return redirect()->route('superadmin.tutorial-categories.index')
            ->with('success', 'Category created successfully.');
    }

    public function edit(TutorialCategory $tutorialCategory)
    {
        return view('superadmin.tutorial-categories.edit', compact('tutorialCategory'));
    }

    public function update(Request $request, TutorialCategory $tutorialCategory)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'slug' => 'nullable|string|max:255|unique:tutorial_categories,slug,' . $tutorialCategory->id,
            'description' => 'nullable|string'
        ]);

        $slug = $request->slug ? Str::slug($request->slug) : Str::slug($request->name);

        $tutorialCategory->update([
            'name' => $request->name,
            'slug' => $slug,
            'description' => $request->description
        ]);

        return redirect()->route('superadmin.tutorial-categories.index')
            ->with('success', 'Category updated successfully.');
    }

    public function destroy(TutorialCategory $tutorialCategory)
    {
        $tutorialCategory->delete();
        return redirect()->route('superadmin.tutorial-categories.index')
            ->with('success', 'Category deleted successfully.');
    }
}
