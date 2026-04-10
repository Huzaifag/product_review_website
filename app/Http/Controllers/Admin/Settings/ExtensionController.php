<?php

namespace App\Http\Controllers\Admin\Settings;

use App\Http\Controllers\Controller;
use App\Models\Extension;
use Illuminate\Http\Request;

class ExtensionController extends Controller
{
    public function index()
    {
        $extensions = Extension::all();
        return view('admin.settings.extensions.index', ['extensions' => $extensions]);
    }

    public function edit(Extension $extension)
    {
        return view('admin.settings.extensions.edit', ['extension' => $extension]);
    }

    public function update(Request $request, Extension $extension)
    {
        foreach ($request->credentials as $key => $value) {
            if (!array_key_exists($key, (array) $extension->credentials)) {
                toastr()->error(d_trans('Credentials parameter error'));
                return back();
            }
        }

        if ($request->has('status')) {
            foreach ($request->credentials as $key => $value) {
                if (empty($value)) {
                    toastr()->error(d_trans(':key cannot be empty', ['key' => d_trans(str_replace('_', ' ', ucfirst($key)))]));
                    return back();
                }
            }
            $request->status = Extension::STATUS_ACTIVE;
        } else {
            $request->status = Extension::STATUS_DISABLED;
        }

        $extension->status = $request->status;
        $extension->credentials = $request->credentials;
        $extension->update();

        toastr()->success(d_trans('Updated Successfully'));
        return back();
    }
}
