<?php

namespace App\Http\Controllers\Admin\Settings;

use App\Http\Controllers\Controller;
use App\Models\MailTemplate;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class MailTemplateController extends Controller
{
    public function index($group = null)
    {
        $group = $group ?? 'general';

        if (licenseType(2) && config('settings.subscription.status')) {
            $mailTemplates = MailTemplate::where('group', $group);
        } else {
            $mailTemplates = MailTemplate::where('group', $group)
                ->whereNotIn('alias', [
                    'business_payment_confirmation',
                    'subscription_about_to_expire',
                    'subscription_expired',
                ]);
        }

        if (request()->filled('search')) {
            $searchTerm = '%' . request('search') . '%';
            $mailTemplates->where(function ($query) use ($searchTerm) {
                $query->where('name', 'like', $searchTerm)
                    ->orWhere('subject', 'like', $searchTerm)
                    ->orWhere('body', 'like', $searchTerm)
                    ->orWhere('shortcodes', 'like', $searchTerm);
            });
        }

        $mailTemplates = $mailTemplates->paginate(50);
        $mailTemplates->appends(request()->only(['search']));

        return view('admin.settings.mail-templates.index', [
            'group' => $group,
            'mailTemplates' => $mailTemplates,
        ]);
    }

    public function edit(MailTemplate $mailTemplate)
    {
        return view('admin.settings.mail-templates.edit', ['mailTemplate' => $mailTemplate]);
    }

    public function update(Request $request, MailTemplate $mailTemplate)
    {
        $validator = Validator::make($request->all(), [
            'subject' => ['required', 'string', 'max:255'],
            'body' => ['required'],
        ]);

        if ($validator->fails()) {
            foreach ($validator->errors()->all() as $error) {
                toastr()->error($error);
            }
            return back();
        }

        if (!$mailTemplate->isPermanent()) {
            $request->status = $request->has('status') ? MailTemplate::STATUS_ACTIVE : MailTemplate::STATUS_DISABLED;
        } else {
            $request->status = MailTemplate::STATUS_ACTIVE;
        }

        $mailTemplate->subject = $request->subject;
        $mailTemplate->status = $request->status;
        $mailTemplate->body = $request->body;
        $mailTemplate->update();

        toastr()->success(d_trans('Updated Successfully'));
        return back();
    }

}