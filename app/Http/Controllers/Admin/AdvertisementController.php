<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Advertisement;
use Illuminate\Http\Request;

class AdvertisementController extends Controller
{
    public function index()
    {
        $advertisements = Advertisement::all();
        return view('admin.advertisements.index', [
            'advertisements' => $advertisements,
        ]);
    }

    public function edit(Advertisement $advertisement)
    {
        return view('admin.advertisements.edit', [
            'advertisement' => $advertisement,
        ]);
    }

    public function update(Request $request, Advertisement $advertisement)
    {
        if ($request->has('status') && is_null($request->code)) {
            toastr()->error(d_trans('The code cannot be empty'));
            return back();
        }

        $request->status = ($request->has('status')) ? 1 : 0;

        $advertisement->code = $request->code;
        $advertisement->status = $request->status;
        $advertisement->update();

        toastr()->success(d_trans('Updated Successfully'));
        return back();
    }
}