<?php

namespace App\Http\Controllers\Admin\Settings;

use App\Http\Controllers\Controller;
use App\Models\CaptchaProvider;
use Illuminate\Http\Request;

class CaptchaProviderController extends Controller
{
    public function index()
    {
        $captchaProviders = CaptchaProvider::all();
        return view('admin.settings.captcha-providers.index', ['captchaProviders' => $captchaProviders]);
    }

    public function edit(CaptchaProvider $captchaProvider)
    {
        return view('admin.settings.captcha-providers.edit', ['captchaProvider' => $captchaProvider]);
    }

    public function update(Request $request, CaptchaProvider $captchaProvider)
    {
        foreach ($request->credentials as $key => $value) {
            if (!array_key_exists($key, (array) $captchaProvider->credentials)) {
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
            $request->status = CaptchaProvider::STATUS_ACTIVE;
        } else {
            $request->status = CaptchaProvider::STATUS_DISABLED;
        }

        $captchaProvider->status = $request->status;
        $captchaProvider->credentials = $request->credentials;
        $captchaProvider->update();

        toastr()->success(d_trans('Updated Successfully'));
        return back();
    }

    public function makeDefault(CaptchaProvider $captchaProvider)
    {
        abort_if($captchaProvider->isDefault(), 401);

        if ($captchaProvider->isDisabled()) {
            toastr()->error(d_trans('The selected captcha provider is not active'));
            return back();
        }

        setEnv('SYSTEM_RECAPTCHA_PROVIDER', $captchaProvider->alias);

        toastr()->success(d_trans('The default captcha providers has been updated'));
        return back();
    }
}
