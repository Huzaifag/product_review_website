<?php

namespace App\Http\Controllers\Admin\Navigation;

use App\Http\Controllers\Controller;
use App\Models\NavbarLink;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class NavbarLinkController extends Controller
{
    public function index()
    {
        $navbarLinks = NavbarLink::whereNull('parent_id')->with('children')->get();

        return view('admin.navigation.navbar-links.index', [
            'navbarLinks' => $navbarLinks,
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
            $list = NavbarLink::find($arr['id']);
            $list->update(['order' => $i, 'parent_id' => null]);
            if (isset($arr['children'])) {
                $sub_i = 1;
                foreach ($arr['children'] as $children) {
                    $list = NavbarLink::find($children['id']);
                    $list->update(['order' => $sub_i, 'parent_id' => $arr['id']]);
                    $sub_i++;
                }
            }
            $i++;
        }

        return response()->json(['success' => true]);
    }

    public function create()
    {
        return view('admin.navigation.navbar-links.create');
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => ['required', 'string', 'max:255'],
            'link' => ['required', 'string', 'max:255'],
            'type' => ['required', 'integer', 'in:' . implode(',', array_keys(NavbarLink::getAvailableTypes()))],
        ]);

        if ($validator->fails()) {
            foreach ($validator->errors()->all() as $error) {
                toastr()->error($error);
            }
            return back()->withInput();
        }

        $navbarLink = new NavbarLink();
        $navbarLink->name = $request->name;
        $navbarLink->link = $request->link;
        $navbarLink->type = $request->type;
        $navbarLink->order = (NavbarLink::all()->count() + 1);
        $navbarLink->lang = getLocale();
        $navbarLink->save();

        toastr()->success(d_trans('Created Successfully'));
        return redirect()->route('admin.navigation.navbar-links.index');
    }

    public function edit(NavbarLink $navbarLink)
    {
        return view('admin.navigation.navbar-links.edit', [
            'navbarLink' => $navbarLink,
        ]);
    }

    public function update(Request $request, NavbarLink $navbarLink)
    {
        $validator = Validator::make($request->all(), [
            'name' => ['required', 'string', 'max:255'],
            'link' => ['required', 'string', 'max:255'],
            'type' => ['required', 'integer', 'in:' . implode(',', array_keys(NavbarLink::getAvailableTypes()))],
        ]);

        if ($validator->fails()) {
            foreach ($validator->errors()->all() as $error) {
                toastr()->error($error);
            }
            return back()->withInput();
        }

        $navbarLink->name = $request->name;
        $navbarLink->link = $request->link;
        $navbarLink->type = $request->type;
        $navbarLink->save();

        toastr()->success(d_trans('Updated Successfully'));
        return back();
    }

    public function destroy(NavbarLink $navbarLink)
    {
        $navbarLink->delete();
        toastr()->success(d_trans('Deleted Successfully'));
        return back();
    }
}