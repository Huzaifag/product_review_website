<?php

namespace App\Http\Controllers\Admin\Sections;

use App\Http\Controllers\Controller;
use App\Models\Faq;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class FaqController extends Controller
{
    public function index()
    {
        $faqs = Faq::all();
        return view('admin.sections.faqs.index', ['faqs' => $faqs]);
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
            $list = Faq::find($arr['id']);
            $list->update(['order' => $i, 'parent_id' => null]);
            $i++;
        }

        return response()->json(['success' => true]);
    }

    public function create()
    {
        return view('admin.sections.faqs.create');
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'title' => ['required', 'string', 'max:255'],
            'body' => ['required', 'string'],
        ]);

        if ($validator->fails()) {
            foreach ($validator->errors()->all() as $error) {
                toastr()->error($error);
            }
            return back()->withInput();
        }

        $faq = new Faq();
        $faq->title = $request->title;
        $faq->body = $request->body;
        $faq->order = Faq::count() + 1;
        $faq->lang = getLocale();
        $faq->save();

        toastr()->success(d_trans('Created Successfully'));
        return redirect()->route('admin.sections.faqs.index');
    }

    public function edit(Faq $faq)
    {
        return view('admin.sections.faqs.edit', ['faq' => $faq]);
    }

    public function update(Request $request, Faq $faq)
    {
        $validator = Validator::make($request->all(), [
            'title' => ['required', 'string', 'max:255'],
            'body' => ['required', 'string'],
        ]);

        if ($validator->fails()) {
            foreach ($validator->errors()->all() as $error) {
                toastr()->error($error);
            }
            return back()->withInput();
        }

        $faq->title = $request->title;
        $faq->body = $request->body;
        $faq->update();

        toastr()->success(d_trans('Updated Successfully'));
        return back();
    }

    public function destroy(Faq $faq)
    {
        $faq->delete();
        toastr()->success(d_trans('Deleted Successfully'));
        return back();
    }
}