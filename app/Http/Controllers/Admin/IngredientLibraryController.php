<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\IngredientLibrary;
use Illuminate\Http\Request;
use Validator;

class IngredientLibraryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $ingredients = IngredientLibrary::orderBy('name')
            ->paginate(20);
        return view('admin.ingredients-library.index', compact('ingredients'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $grades = ['good', 'average', 'poor'];
        return view('admin.ingredients-library.create', compact('grades'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255|unique:ingredients_library,name',
            'inci_name' => 'nullable|string|max:255',
            'severity' => 'nullable|in:none,avoid,concern,caution',
            'concern_description' => 'nullable|string',
            'health_effects' => 'nullable|string',
            'regulatory_status' => 'nullable|string|max:255',
            'cas_number' => 'nullable|string|max:255',
            'is_published' => 'nullable|boolean',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        IngredientLibrary::create($request->all());
        toastr()->success(d_trans('Created Successfully'));

        return redirect()->route('admin.ingredients-library.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $ingredient = IngredientLibrary::findOrFail($id);
        return view('admin.ingredients-library.show', compact('ingredient'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $ingredient = IngredientLibrary::findOrFail($id);
        $grades = ['good', 'average', 'poor'];
        return view('admin.ingredients-library.edit', compact('ingredient', 'grades'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $ingredient = IngredientLibrary::findOrFail($id);

        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255|unique:ingredients_library,name,' . $id,
            'inci_name' => 'nullable|string|max:255',
            'severity' => 'nullable|in:none,avoid,concern,caution',
            'concern_description' => 'nullable|string',
            'health_effects' => 'nullable|string',
            'regulatory_status' => 'nullable|string|max:255',
            'cas_number' => 'nullable|string|max:255',
            'is_published' => 'nullable|boolean',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        $ingredient->update($request->all());
        toastr()->success(d_trans('Updated Successfully'));

        return redirect()->route('admin.ingredients-library.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $ingredient = IngredientLibrary::findOrFail($id);
        $ingredient->delete();
        toastr()->success(d_trans('Deleted Successfully'));

        return redirect()->route('admin.ingredients-library.index');
    }
}
