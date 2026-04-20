<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Plan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class PlanController extends Controller
{
    public function index()
    {
        $plans = Plan::query();

        if (request()->filled('search')) {
            $searchTerm = '%' . request('search') . '%';
            $plans->where('name', 'like', $searchTerm)
                ->OrWhere('price', 'like', $searchTerm)
                ->OrWhere('custom_features', 'like', $searchTerm);
        }

        $plans = $plans->get();

        return view('admin.plans.index', [
            'plans' => $plans,
        ]);
    }

    public function sortable(Request $request)
    {
        $ids = $request->ids;

        if (!$ids || is_null($ids) || !is_array($ids)) {
            return response()->json(['error' => d_trans('Failed to sort the table')]);
        }

        foreach ($ids as $sortOrder => $id) {
            $plan = Plan::find($id);
            $plan->sort_id = ($sortOrder + 1);
            $plan->update();
        }

        return response()->json(['success' => true]);
    }

    public function create()
    {
        $intervals = Plan::getAvailableIntervals();

        return view('admin.plans.create', ['intervals' => $intervals]);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => ['required', 'string', 'max:255'],
            'interval' => ['required', 'string', 'in:' . implode(',', array_keys(Plan::getAvailableIntervals()))],
            'price' => ['required', 'numeric', 'min:0'],           // Changed: allow 0 for Free plans
            'products_limit' => ['nullable', 'integer', 'min:0'],           // allow 0 or null
            'custom_features.*' => ['nullable', 'string', 'max:255'],          // made nullable
                      
        ]);

        if ($validator->fails()) {
            foreach ($validator->errors()->all() as $error) {
                toastr()->error($error);
            }
            return back()->withInput();
        }

        // Process checkboxes and defaults
        $data = $request->only([
            'name',
            'interval',
            'price',
            'products_limit',
            'custom_features',
        ]);

        $data['status'] = $request->has('status') ? Plan::STATUS_ACTIVE : Plan::STATUS_DISABLED;
        $data['is_featured'] = $request->has('featured') ? Plan::FEATURED : Plan::NOT_FEATURED;
        $data['employees'] = $request->has('employees') ? Plan::EMPLOYEES_FEATURE : Plan::NO_EMPLOYEES_FEATURE;
        $data['categories'] = $request->has('categories') ? Plan::CATEGORIES_FEATURE : Plan::NO_CATEGORIES_FEATURE;

        // Handle null/empty values
        $data['products_limit'] = $request->filled('products_limit') ? $request->products_limit : null;
        $data['custom_features'] = $request->filled('custom_features') ? $request->custom_features : [];

        $plan = Plan::create($data);

        // Unfeature other plans in same interval
        if ($plan->is_featured) {
            Plan::where('interval', $plan->interval)
                ->where('id', '!=', $plan->id)
                ->update(['is_featured' => Plan::NOT_FEATURED]);
        }

        toastr()->success(d_trans('Created Successfully'));
        return redirect()->route('admin.plans.edit', $plan->id);
    }
    public function edit(Plan $plan)
    {
         $intervals = Plan::getAvailableIntervals();
        return view('admin.plans.edit', [
            'plan' => $plan,
            'intervals' => $intervals,
        ]);
    }

    public function update(Request $request, Plan $plan)
    {
       $validator = Validator::make($request->all(), [
            'name' => ['required', 'string', 'max:255'],
            'interval' => ['required', 'string', 'in:' . implode(',', array_keys(Plan::getAvailableIntervals()))],
            'price' => ['required', 'numeric', 'min:0'],           // Changed: allow 0 for Free plans
            'products_limit' => ['nullable', 'integer', 'min:0'],           // allow 0 or null
            'custom_features.*' => ['nullable', 'string', 'max:255'],          // made nullable
            'businesses' => ['nullable', 'integer', 'min:0'],           // added if needed
        ]);

        if ($validator->fails()) {
            foreach ($validator->errors()->all() as $error) {
                toastr()->error($error);
            }
            return back()->withInput();
        }



        $request->status = $request->has('status') ? Plan::STATUS_ACTIVE : Plan::STATUS_DISABLED;
        $request->featured = $request->has('featured') ? Plan::FEATURED : Plan::NOT_FEATURED;
        $request->employees = $request->has('employees') ? Plan::EMPLOYEES_FEATURE : Plan::NO_EMPLOYEES_FEATURE;
        $request->categories = $request->has('categories') ? Plan::CATEGORIES_FEATURE : Plan::NO_CATEGORIES_FEATURE;

        $plan->name = $request->name;
        $plan->price = $request->price;
        $plan->interval = $request->interval;
        $plan->employees = $request->employees;
        $plan->categories = $request->categories;
        $plan->custom_features = $request->custom_features;
        $plan->products_limit = $request->products_limit;
        $plan->status = $request->status;
        $plan->is_featured = $request->featured;
        $plan->update();

        if ($plan->isFeatured()) {
            $plans = Plan::where('interval', $plan->interval)
                ->whereNot('id', $plan->id)
                ->update(['is_featured' => Plan::NOT_FEATURED]);
        }

        toastr()->success(d_trans('Updated Successfully'));
        return back();
    }

    public function destroy(Plan $plan)
    {
        if ($plan->subscriptions->count() > 0) {
            toastr()->error(d_trans('This plan has subscriptions it cannot be deleted'));
            return back();
        }

        $plan->delete();
        toastr()->success(d_trans('Deleted Successfully'));
        return back();
    }
}