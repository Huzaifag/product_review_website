<?php

namespace App\Http\Controllers\Admin\Sections;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\HomeSection;
use App\Models\SubCategory;
use App\Models\SubSubCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class HomeSectionController extends Controller
{
    public const CONTENT_FROM_CATEGORY = "category";
    public const CONTENT_FROM_SUBCATEGORY = "sub_category";
    public const CONTENT_FROM_SUB_SUBCATEGORY = "sub_sub_category";

    public function index()
    {
        $homeSections = HomeSection::all();
        return view('admin.sections.home-sections.index', [
            'homeSections' => $homeSections,
        ]);
    }

    public function nestable(Request $request)
    {
        $ids = $request->ids;

        if (!$ids || is_null($ids)) {
            return response()->json(['error' => d_trans('Failed to sort the list')]);
        }

        $data = json_decode($ids, true);
        $i = 1;
        foreach ($data as $arr) {
            $list = HomeSection::find($arr['id']);
            $list->update(['order' => $i, 'parent_id' => null]);
            $i++;
        }

        return response()->json(['success' => true]);
    }

    public function create()
    {
        $categories = Category::select('id', 'name')->get();
        $subCategories = SubCategory::select('id', 'name')->get();
        $subSubCategories = SubSubCategory::select('id', 'name')->get();

        return view('admin.sections.home-sections.create', [
            'categories' => $categories,
            'subCategories' => $subCategories,
            'subSubCategories' => $subSubCategories,
        ]);
    }

    public function store(Request $request)
    {
        $rules = [
            'name' => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string', 'max:500'],
            'items_number' => ['required', 'integer', 'min:1', 'max:100'],
            'cache_expiry_time' => ['required', 'integer', 'min:1', 'max:525600'],
        ];

        if ($request->content_from == self::CONTENT_FROM_CATEGORY) {
            $rules['category'] = ['required', 'integer', 'exists:categories,id'];
            $request->sub_category = null;
            $request->sub_sub_category = null;
        } elseif ($request->content_from == self::CONTENT_FROM_SUBCATEGORY) {
            $rules['sub_category'] = ['required', 'integer', 'exists:sub_categories,id'];
            $request->category = null;
            $request->sub_sub_category = null;
        } elseif ($request->content_from == self::CONTENT_FROM_SUB_SUBCATEGORY) {
            $rules['sub_sub_category'] = ['required', 'integer', 'exists:sub_sub_categories,id'];
            $request->category = null;
            $request->sub_category = null;
        }

        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            foreach ($validator->errors()->all() as $error) {
                toastr()->error($error);
            }
            return back()->withInput();
        }

        $request->status = $request->has('status') ? HomeSection::STATUS_ACTIVE : HomeSection::STATUS_DISABLED;

        $homeSection = new HomeSection();
        $homeSection->name = $request->name;
        $homeSection->description = $request->description;
        $homeSection->category_id = $request->category;
        $homeSection->sub_category_id = $request->sub_category;
        $homeSection->sub_sub_category_id = $request->sub_sub_category;
        $homeSection->items_number = $request->items_number;
        $homeSection->cache_expiry_time = $request->cache_expiry_time;
        $homeSection->status = $request->status;
        $homeSection->save();

        toastr()->success(d_trans('Created Successfully'));
        return redirect()->route('admin.sections.home-sections.edit', $homeSection->id);
    }

    public function edit(HomeSection $homeSection)
    {
        $categories = null;
        $subCategories = null;
        $subSubCategories = null;

        if (!$homeSection->isPermanent()) {
            $categories = Category::select('id', 'name')->get();
            $subCategories = SubCategory::select('id', 'name')->get();
            $subSubCategories = SubSubCategory::select('id', 'name')->get();
        }

        return view('admin.sections.home-sections.edit', [
            'homeSection' => $homeSection,
            'categories' => $categories,
            'subCategories' => $subCategories,
            'subSubCategories' => $subSubCategories,
        ]);
    }

    public function update(Request $request, HomeSection $homeSection)
    {
        $rules = [
            'name' => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string', 'max:500'],
        ];

        if (!$homeSection->isPermanent()) {
            if ($request->content_from == self::CONTENT_FROM_CATEGORY) {
                $rules['category'] = ['required', 'integer', 'exists:categories,id'];
                $request->sub_category = null;
                $request->sub_sub_category = null;
            } elseif ($request->content_from == self::CONTENT_FROM_SUBCATEGORY) {
                $rules['sub_category'] = ['required', 'integer', 'exists:sub_categories,id'];
                $request->category = null;
                $request->sub_sub_category = null;
            } elseif ($request->content_from == self::CONTENT_FROM_SUB_SUBCATEGORY) {
                $rules['sub_sub_category'] = ['required', 'integer', 'exists:sub_sub_categories,id'];
                $request->category = null;
                $request->sub_category = null;
            }
        } else {
            $request->category = null;
            $request->sub_category = null;
            $request->sub_sub_category = null;
        }

        if ($homeSection->items_number) {
            $rules['items_number'] = ['required', 'integer', 'min:1', 'max:100'];
        } else {
            $request->items_number = null;
        }

        if ($homeSection->cache_expiry_time) {
            $rules['cache_expiry_time'] = ['required', 'integer', 'min:1', 'max:525600'];
        } else {
            $request->cache_expiry_time = null;
        }

        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            foreach ($validator->errors()->all() as $error) {
                toastr()->error($error);
            }
            return back()->withInput();
        }

        $request->status = $request->has('status') ? HomeSection::STATUS_ACTIVE : HomeSection::STATUS_DISABLED;

        $homeSection->name = $request->name;
        $homeSection->description = $request->description;
        $homeSection->category_id = $request->category;
        $homeSection->sub_category_id = $request->sub_category;
        $homeSection->sub_sub_category_id = $request->sub_sub_category;
        $homeSection->items_number = $request->items_number;
        $homeSection->cache_expiry_time = $request->cache_expiry_time;
        $homeSection->status = $request->status;
        $homeSection->save();

        toastr()->success(d_trans('Updated Successfully'));
        return back();
    }

    public function destroy(HomeSection $homeSection)
    {
        if (!$homeSection->isPermanent()) {
            $homeSection->delete();
            toastr()->success(d_trans('Deleted Successfully'));
        }

        return back();
    }
}
