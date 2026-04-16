<?php

namespace App\Http\Controllers\Admin;

use App\Handlers\FileHandler;
use App\Http\Controllers\Controller;
use App\Models\Brand;
use Exception;
use Illuminate\Http\Request;
use Validator;

class BrandController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $brands = Brand::active()->orderBy('name')
            ->paginate(20);
        return view('admin.brands.index', compact('brands'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.brands.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'slug' => 'required|string|max:255|unique:brands,slug',
            'logo' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg,webp|max:2048',
            'description' => 'nullable|string',
            'status' => 'required|in:active,inactive',
            'website_url' => 'nullable|url|max:255',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        $data = $request->only(['name', 'slug', 'description', 'status', 'website_url']);
       

        
        if ($request->hasFile('logo')) {
            try {
                $data['logo'] = FileHandler::upload($request->file('logo'), [
                    'path' => 'images/brands/',
                ]);
            } catch (Exception $e) {
                toastr()->error($e->getMessage());
                return back()->withInput();
            }
        }

        Brand::create($data);
        toastr()->success(d_trans('Created Successfully'));

        return redirect()->route('admin.brands.index');

    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $brand = Brand::findOrFail($id);
        return view('admin.brands.show', compact('brand'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $brand = Brand::findOrFail($id);
        return view('admin.brands.edit', compact('brand'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $brand = Brand::findOrFail($id);

        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'slug' => 'required|string|max:255|unique:brands,slug,' . $brand->id,
            'logo' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg,webp|max:2048',
            'description' => 'nullable|string',
            'status' => 'required|in:active,inactive',
            'website_url' => 'nullable|url|max:255',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        $data = $request->only(['name', 'slug', 'description', 'status', 'website_url']);
        if ($request->hasFile('logo')) {
            try {
                $data['logo'] = FileHandler::upload($request->file('logo'), [
                    'path' => 'images/brands/',
                ]);
            } catch (Exception $e) {
                toastr()->error($e->getMessage());
                return back()->withInput();
            }
        }

        $brand->update($data);
        toastr()->success(d_trans('Updated Successfully'));
        return redirect()->route('admin.brands.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $brand = Brand::findOrFail($id);
        $brand->delete();
        toastr()->success(d_trans('Deleted Successfully'));
        return redirect()->route('admin.brands.index');
    }
}
