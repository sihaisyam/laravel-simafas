<?php

namespace App\Http\Controllers;

use App\Models\Facility;
use App\Models\Category;
use Illuminate\Http\Request;

class FacilityController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $facilities = Facility::with('category')
            ->when(request()->search, function($query) {
                $query->where('name', 'like', '%'.request()->search.'%')
                      ->orWhereHas('category', function($q) {
                          $q->where('name', 'like', '%'.request()->search.'%');
                      });
            })
            ->latest()
            ->paginate(10);

        return view('facilities.index', compact('facilities'))
            ->with('i', (request()->input('page', 1) - 1) * 10);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $categories = Category::all();
        return view('facilities.create', compact('categories'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'category_id' => 'required|exists:categories,id',
            'capacity' => 'required|integer|min:1',
            'location' => 'required|string|max:255',
            'hourly_rate' => 'nullable|numeric|min:0',
            'daily_rate' => 'nullable|numeric|min:0',
        ]);

        try {
            $facility = Facility::create([
                'name' => $request->name,
                'category_id' => $request->category_id,
                'capacity' => $request->capacity,
                'location' => $request->location,
                'hourly_rate' => $request->hourly_rate,
                'daily_rate' => $request->daily_rate,
            ]);

            return redirect()->route('facilities.index')
                ->with('success', 'Facility "'.$facility->name.'" has been created successfully!');
        } catch (\Throwable $th) {
            return back()->with('error', $th->getMessage());
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Facility $facility)
    {
        return view('facilities.show', compact('facility'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Facility $facility)
    {
        $categories = Category::all();
        return view('facilities.edit', compact('facility', 'categories'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Facility $facility)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'category_id' => 'required|exists:categories,id',
            'capacity' => 'required|integer|min:1',
            'location' => 'required|string|max:255',
            'hourly_rate' => 'nullable|numeric|min:0',
            'daily_rate' => 'nullable|numeric|min:0',
        ]);

        try {
            $facility->update([
                'name' => $request->name,
                'category_id' => $request->category_id,
                'capacity' => $request->capacity,
                'location' => $request->location,
                'hourly_rate' => $request->hourly_rate,
                'daily_rate' => $request->daily_rate,
            ]);

            return redirect()->route('facilities.index')
                ->with('success', 'Facility "'.$facility->name.'" has been updated successfully!');
        } catch (\Throwable $th) {
            return back()->with('error', $th->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Facility $facility)
    {
        try {
            $facilityName = $facility->name;
            $facility->delete();

            return redirect()->route('facilities.index')
                ->with('success', 'Facility "'.$facilityName.'" has been deleted successfully!');
        } catch (\Throwable $th) {
            return back()->with('error', $th->getMessage());
        }
    }
}