<?php

namespace App\Http\Controllers\Admin\Settings;

use App\Handlers\FileHandler;
use App\Http\Controllers\Controller;
use App\Models\Setting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class SettingsController extends Controller
{
    public function index()
    {
        return view('admin.settings.index');
    }

    public function general()
    {
        return view('admin.settings.general');
    }

    public function generalUpdate(Request $request)
    {
        $rules = [
            'general.site_name' => ['required', 'string', 'block_patterns', 'max:255'],
            'general.site_url' => ['required', 'block_patterns', 'url'],
            'general.contact_email' => ['nullable', 'string', 'email', 'block_patterns'],
            'general.date_format' => ['required', 'in:' . implode(',', array_keys(Setting::getAvailableDateFormats()))],
            'general.timezone' => ['required', 'in:' . implode(',', array_keys(Setting::getAvailableTimezones()))],
            'seo.title' => ['nullable', 'string', 'block_patterns', 'max:255'],
            'seo.description' => ['nullable', 'string', 'block_patterns', 'max:255'],
            'seo.keywords' => ['nullable', 'string', 'block_patterns', 'max:255'],
            'social_links.*' => ['nullable', 'string', 'block_patterns'],
            'links.*' => ['nullable', 'string', 'block_patterns'],
        ];

        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            foreach ($validator->errors()->all() as $error) {
                toastr()->error($error);
            }
            return back();
        }

        if ($request->has('action.email_verification') && !config('settings.smtp.status')) {
            toastr()->error(d_trans('SMTP is not enabled'));
            return back()->withInput();
        }

        $requestData = $request->except('_token');

        if ($request->has('actions.contact_page') && empty($requestData['general']['contact_email'])) {
            toastr()->error(d_trans('Contact email is required to enable contact page'));
            return back()->withInput();
        }

        $requestData['actions'] = [];
        foreach (config('settings.actions') as $key => $value) {
            $requestData['actions'][$key] = ($request->has("actions.$key")) ? 1 : 0;
        }

        foreach ($requestData as $key => $value) {
            $update = Setting::updateSettings($key, $value);
            if (!$update) {
                toastr()->error(d_trans('Updated Error'));
                return back();
            }
        }

        setEnv('APP_NAME', Str::slug($requestData['general']['site_name'], '_'));
        setEnv('APP_URL', $requestData['general']['site_url']);
        setEnv('APP_TIMEZONE', $requestData['general']['timezone'], true);

        toastr()->success(d_trans('Updated Successfully'));
        return back();
    }

    public function financial()
    {
        return view('admin.settings.financial');
    }

    public function financialUpdate(Request $request)
    {
        $rules = [
            'currency.code' => ['required', 'string', 'max:4'],
            'currency.symbol' => ['required', 'string', 'max:4'],
            'currency.position' => ['required', 'integer', 'min:1', 'max:2'],
        ];

        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            foreach ($validator->errors()->all() as $error) {
                toastr()->error($error);
            }
            return back();
        }

        $requestData = $request->except('_token');

        foreach ($requestData as $key => $value) {
            $update = Setting::updateSettings($key, $value);
            if (!$update) {
                toastr()->error(d_trans('Updated Error'));
                return back();
            }
        }

        toastr()->success(d_trans('Updated Successfully'));
        return back();
    }

    public function smtp()
    {
        return view('admin.settings.smtp');
    }

    public function smtpUpdate(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'smtp.mailer' => ['required_if:smtp.status,on', 'in:smtp,sendmail'],
            'smtp.host' => ['required_if:smtp.status,on'],
            'smtp.port' => ['required_if:smtp.status,on'],
            'smtp.username' => ['required_if:smtp.status,on'],
            'smtp.password' => ['required_if:smtp.status,on'],
            'smtp.encryption' => ['required_if:smtp.status,on', 'in:ssl,tls'],
            'smtp.from_email' => ['required_if:smtp.status,on'],
            'smtp.from_name' => ['required_if:smtp.status,on'],
        ]);

        if ($validator->fails()) {
            foreach ($validator->errors()->all() as $error) {
                toastr()->error($error);
            }
            return back();
        }

        $data = $request->smtp;
        $data['status'] = ($request->has('smtp.status')) ? 1 : 0;
        $update = Setting::updateSettings('smtp', $data);

        if ($update) {
            setEnv('MAIL_MAILER', $data['mailer']);
            setEnv('MAIL_HOST', $data['host']);
            setEnv('MAIL_PORT', $data['port']);
            setEnv('MAIL_USERNAME', $data['username']);
            setEnv('MAIL_PASSWORD', $data['password'], true);
            setEnv('MAIL_ENCRYPTION', $data['encryption']);
            setEnv('MAIL_FROM_ADDRESS', $data['from_email']);
            setEnv('MAIL_FROM_NAME', $data['from_name'], true);
            toastr()->success(d_trans('Updated Successfully'));
            return back();
        } else {
            toastr()->error(d_trans('Updated Error'));
            return back();
        }
    }

    public function smtpTest(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => ['required', 'email'],
        ]);

        if ($validator->fails()) {
            foreach ($validator->errors()->all() as $error) {toastr()->error($error);}
            return back()->withInput();
        }

        if (!config('settings.smtp.status')) {
            toastr()->error(d_trans('SMTP is not enabled'));
            return back()->withInput();
        }

        try {
            $email = $request->email;
            \Mail::raw('Hi, This is a test mail to ' . $email, function ($message) use ($email) {
                $message->to($email)
                    ->subject('Test mail to ' . $email);
            });

            toastr()->success(d_trans('Sent successfully'));
            return back();
        } catch (\Exception $e) {
            toastr()->error(d_trans('Sending failed'));
            return back();
        }
    }

    public function user()
    {
        return view('admin.settings.user');
    }

    public function userUpdate(Request $request)
    {
        if ($request->has('user.action.email_verification') && !config('settings.smtp.status')) {
            toastr()->error(d_trans('SMTP is not enabled'));
            return back()->withInput();
        }

        $requestData = $request->except('_token');

        $requestData['user']['actions'] = [];
        foreach (config('settings.user.actions') as $key => $value) {
            $requestData['user']['actions'][$key] = ($request->has("user.actions.$key")) ? 1 : 0;
        }

        foreach ($requestData as $key => $value) {
            $update = Setting::updateSettings($key, $value);
            if (!$update) {
                toastr()->error(d_trans('Updated Error'));
                return back();
            }
        }

        toastr()->success(d_trans('Updated Successfully'));
        return back();
    }

    public function business()
    {
        return view('admin.settings.business');
    }

    public function businessUpdate(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'business.default.businesses' => ['nullable', 'integer', 'min:1'],
            'business.trending_number' => ['required', 'integer', 'min:1'],
            'business.best_rating_number' => ['required', 'integer', 'min:1'],
            'business.media.*' => ['nullable', 'mimes:jpg,jpeg,png,webp', 'max:2048'],
        ]);

        if ($validator->fails()) {
            foreach ($validator->errors()->all() as $error) {
                toastr()->error($error);
            }
            return back();
        }

        if ($request->has('business.action.email_verification') && !config('settings.smtp.status')) {
            toastr()->error(d_trans('SMTP is not enabled'));
            return back()->withInput();
        }

        $requestData = $request->except('_token');

        $requestData['business']['actions'] = [];
        foreach (config('settings.business.actions') as $key => $value) {
            $requestData['business']['actions'][$key] = ($request->has("business.actions.$key")) ? 1 : 0;
        }

        $requestData['business']['default']['employees'] = ($request->has("business.default.employees")) ? 1 : 0;
        $requestData['business']['default']['categories'] = ($request->has("business.default.categories")) ? 1 : 0;

        $requestData['business']['media'] = [];
        foreach (config('settings.business.media') as $key => $value) {
            try {
                $alias = "business.media.{$key}";
                if ($request->has($alias)) {
                    $logo = FileHandler::upload($request->file($alias), [
                        'name' => 'default-logo',
                        'path' => 'images/businesses/',
                        'old_file' => $value,
                    ]);
                } else {
                    $logo = $value;
                }
            } catch (Exception $e) {
                toastr()->error($e->getMessage());
                return back();
            }

            $requestData['business']['media'][$key] = $logo;
        }

        foreach ($requestData as $key => $value) {
            $update = Setting::updateSettings($key, $value);
            if (!$update) {
                toastr()->error(d_trans('Updated Error'));
                return back();
            }
        }

        toastr()->success(d_trans('Updated Successfully'));
        return back();
    }

    public function subscription()
    {
        return view('admin.settings.subscription');
    }

    public function subscriptionUpdate(Request $request)
    {
        if (config('settings.subscription.status')) {
            $validator = Validator::make($request->all(), [
                'subscription.before_expiring_reminder_days' => ['required', 'integer', 'min:1'],
                'subscription.after_expiring_reminder_days' => ['required', 'integer', 'min:1'],
                'subscription.data_delete_days' => ['required', 'integer', 'min:1'],
            ]);

            if ($validator->fails()) {
                foreach ($validator->errors()->all() as $error) {
                    toastr()->error($error);
                }
                return back();
            }
        }

        $requestData = $request->except('_token');

        $requestData['subscription']['status'] = ($request->has("subscription.status")) ? 1 : 0;

        foreach ($requestData as $key => $value) {
            $update = Setting::updateSettings($key, $value);
            if (!$update) {
                toastr()->error(d_trans('Updated Error'));
                return back();
            }
        }

        toastr()->success(d_trans('Updated Successfully'));
        return back();
    }

    public function kyc()
    {
        return view('admin.settings.kyc');
    }

    public function kycUpdate(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'kyc.media.*' => ['nullable', 'mimes:jpg,jpeg,png,svg', 'max:2048'],
        ]);

        if ($validator->fails()) {
            foreach ($validator->errors()->all() as $error) {
                toastr()->error($error);
            }
            return back();
        }

        $requestData = $request->except('_token');

        $requestData['kyc']['actions'] = [];
        foreach (config('settings.kyc.actions') as $key => $value) {
            $requestData['kyc']['actions'][$key] = ($request->has("kyc.actions.$key")) ? 1 : 0;
        }

        $requestData['kyc']['media'] = [];
        foreach (config('settings.kyc.media') as $key => $value) {
            try {
                $alias = "kyc.media.{$key}";
                if ($request->has($alias)) {
                    $logo = FileHandler::upload($request->file($alias), [
                        'path' => 'images/kyc/',
                        'old_file' => $value,
                    ]);
                } else {
                    $logo = $value;
                }
            } catch (Exception $e) {
                toastr()->error($e->getMessage());
                return back();
            }

            $requestData['kyc']['media'][$key] = $logo;
        }

        foreach ($requestData as $key => $value) {
            $update = Setting::updateSettings($key, $value);
            if (!$update) {
                toastr()->error(d_trans('Updated Error'));
                return back();
            }
        }

        toastr()->success(d_trans('Updated Successfully'));
        return back();
    }
}