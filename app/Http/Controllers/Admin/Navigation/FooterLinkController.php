<?php

namespace App\Http\Controllers\Admin\Navigation;

use App\Http\Controllers\Controller;
use App\Models\FooterLink;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class FooterLinkController extends Controller
{
    public function index()
    {
        $footerLinks = FooterLink::whereNull('parent_id')->with('children')->get();

        return view('admin.navigation.footer-links.index', [
            'footerLinks' => $footerLinks,
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
            $list = FooterLink::find($arr['id']);
            $list->update(['order' => $i, 'parent_id' => null]);
            if (isset($arr['children'])) {
                $sub_i = 1;
                foreach ($arr['children'] as $children) {
                    $list = FooterLink::find($children['id']);
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
        return view('admin.navigation.footer-links.create');
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => ['required', 'string', 'max:255'],
            'link' => ['required', 'string', 'max:255'],
            'type' => ['required', 'integer', 'in:' . implode(',', array_keys(FooterLink::getAvailableTypes()))],
        ]);

        if ($validator->fails()) {
            foreach ($validator->errors()->all() as $error) {
                toastr()->error($error);
            }
            return back()->withInput();
        }

        $footerLink = new FooterLink();
        $footerLink->name = $request->name;
        $footerLink->link = $request->link;
        $footerLink->type = $request->type;
        $footerLink->order = (FooterLink::all()->count() + 1);
        $footerLink->lang = getLocale();
        $footerLink->save();

        toastr()->success(d_trans('Created Successfully'));
        return redirect()->route('admin.navigation.footer-links.index');
    }

    public function edit(FooterLink $footerLink)
    {
        return view('admin.navigation.footer-links.edit', [
            'footerLink' => $footerLink,
        ]);
    }

    public function update(Request $request, FooterLink $footerLink)
    {
        $validator = Validator::make($request->all(), [
            'name' => ['required', 'string', 'max:255'],
            'link' => ['required', 'string', 'max:255'],
            'type' => ['required', 'integer', 'in:' . implode(',', array_keys(FooterLink::getAvailableTypes()))],
        ]);

        if ($validator->fails()) {
            foreach ($validator->errors()->all() as $error) {
                toastr()->error($error);
            }
            return back()->withInput();
        }

        $footerLink->name = $request->name;
        $footerLink->link = $request->link;
        $footerLink->type = $request->type;
        $footerLink->save();

        toastr()->success(d_trans('Updated Successfully'));
        return back();
    }

    public function destroy(FooterLink $footerLink)
    {
        $footerLink->delete();
        toastr()->success(d_trans('Deleted Successfully'));
        return back();
    }
}