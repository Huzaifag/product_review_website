<?php

namespace App\Http\Controllers\Admin\Settings;

use App\Http\Controllers\Controller;
use App\Models\OAuthProvider;
use Illuminate\Http\Request;

class OAuthProviderController extends Controller
{
    public function index()
    {
        $oauthProviders = OAuthProvider::all();
        return view('admin.settings.oauth-providers.index', ['oauthProviders' => $oauthProviders]);
    }

    public function edit(OAuthProvider $oauthProvider)
    {
        return view('admin.settings.oauth-providers.edit', ['oauthProvider' => $oauthProvider]);
    }

    public function update(Request $request, OAuthProvider $oauthProvider)
    {
        foreach ($request->credentials as $key => $value) {
            if (!array_key_exists($key, (array) $oauthProvider->credentials)) {
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
            $request->status = OAuthProvider::STATUS_ACTIVE;
        } else {
            $request->status = OAuthProvider::STATUS_DISABLED;
        }

        $oauthProvider->status = $request->status;
        $oauthProvider->credentials = $request->credentials;
        $oauthProvider->update();

        toastr()->success(d_trans('Updated Successfully'));
        return back();
    }

}
