<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $categories = Category::when(request()->search, function ($query) {
            $query->where('name', 'like', '%' . request()->search . '%');
        })->latest()->paginate(10);

        return view('categories.index', compact('categories'))
            ->with('i', (request()->input('page', 1) - 1) * 10);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('categories.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:categories',
        ]);

        try {
            $category = Category::create([
                'name' => $request->name,
            ]);

            return redirect()->route('categories.index')
                ->with('success', 'Category "'.$category->name.'" has been created successfully!');
        } catch (\Throwable $th) {
            return back()->with('error', $th->getMessage());
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        // Optional: Implement if needed
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Category $category)
    {
        return view('categories.edit', compact('category'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Category $category)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:categories,name,'.$category->id,
        ]);

        try {
            $category->update([
                'name' => $request->name,
            ]);

            return redirect()->route('categories.index')
                ->with('success', 'Category "'.$category->name.'" has been updated successfully!');
        } catch (\Throwable $th) {
            return back()->with('error', $th->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Category $category)
    {
        try {
            $categoryName = $category->name;
            $category->delete();

            return redirect()->route('categories.index')
                ->with('success', 'Category "'.$categoryName.'" has been deleted successfully!');
        } catch (\Throwable $th) {
            return back()->with('error', $th->getMessage());
        }
    }
}