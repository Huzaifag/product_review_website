<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\TestAttribute;
use Illuminate\Http\Request;
use Validator;

class TestAttributeController extends Controller
{
    public function index()
    {
        $testAttributes = TestAttribute::query();

        if (request()->filled('search')) {
            $searchTerm = '%'.request('search').'%';
            $testAttributes->where('name', 'like', $searchTerm);
        }

        if (request()->filled('status')) {
            $testAttributes->where('status', request('status'));
        }

        $testAttributes = $testAttributes->orderBy('name', 'asc')->paginate(20);
        $testAttributes->appends(request()->only(['search', 'status']));

        return view('admin.test-attributes.index', compact('testAttributes'));
    }

    public function create()
    {
        return view('admin.test-attributes.create');
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'type' => 'required|in:text,number,boolean,select',
            'options' => 'nullable|string',
            'status' => 'required|in:active,inactive',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $data = $request->only(['name', 'type', 'status']);

        // Parse comma-separated options into an array
        if ($request->filled('options')) {
            $data['options'] = array_filter(array_map('trim', explode(',', $request->options)));
        }

        TestAttribute::create($data);
        toastr()->success(d_trans('Created Successfully'));

        return redirect()->route('admin.test-attributes.index');
    }

    public function edit(string $id)
    {
        $attribute = TestAttribute::findOrFail($id);

        return view('admin.test-attributes.edit', compact('attribute'));
    }

    public function update(Request $request, string $id)
    {
        $attribute = TestAttribute::findOrFail($id);

        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'type' => 'required|in:text,number,boolean,select',
            'options' => 'nullable|string',
            'status' => 'required|in:active,inactive',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $data = $request->only(['name', 'type', 'status']);

        if ($request->filled('options')) {
            $data['options'] = array_filter(array_map('trim', explode(',', $request->options)));
        } else {
            $data['options'] = null;
        }

        $attribute->update($data);
        toastr()->success(d_trans('Updated Successfully'));

        return redirect()->route('admin.test-attributes.index');
    }

    public function destroy(string $id)
    {
        $attribute = TestAttribute::findOrFail($id);
        $attribute->delete();
        toastr()->success(d_trans('Deleted Successfully'));

        return redirect()->route('admin.test-attributes.index');
    }
}
