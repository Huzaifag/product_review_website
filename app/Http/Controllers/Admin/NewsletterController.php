<?php

namespace App\Http\Controllers\Admin;

use App\Exports\NewsletterSubscribersExport;
use App\Handlers\FileHandler;
use App\Http\Controllers\Controller;
use App\Jobs\SendMailToAllSubscribers;
use App\Models\NewsletterSubscriber;
use App\Models\Setting;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Maatwebsite\Excel\Facades\Excel;

class NewsletterController extends Controller
{
    public function index()
    {
        $hasSubscribers = NewsletterSubscriber::count() > 0;

        $subscribers = NewsletterSubscriber::query();

        if (request()->filled('search')) {
            $searchTerm = '%' . request('search') . '%';
            $subscribers->where(function ($query) use ($searchTerm) {
                $query->where('id', 'like', $searchTerm)
                    ->OrWhere('email', 'like', $searchTerm);
            });
        }

        $subscribers = $subscribers->orderbyDesc('id')->paginate(50);
        $subscribers->appends(request()->only(['search']));

        return view('admin.newsletter.subscribers', [
            'hasSubscribers' => $hasSubscribers,
            'subscribers' => $subscribers,
        ]);
    }

    public function sendMail()
    {
        return view('admin.newsletter.sendmail');
    }

    public function sendMailSend(Request $request)
    {
        if (NewsletterSubscriber::count() < 1) {
            toastr()->error(d_trans('You do not have any subscribers'));
            return back();
        }

        $validator = Validator::make($request->all(), [
            'subject' => ['required', 'string', 'block_patterns'],
            'reply_to' => ['required', 'email', 'block_patterns'],
            'message' => ['required', 'string'],
        ]);

        if ($validator->fails()) {
            foreach ($validator->errors()->all() as $error) {
                toastr()->error($error);
            }
            return back();
        }

        if (!config('settings.smtp.status')) {
            toastr()->error(d_trans('SMTP is not enabled'));
            return back()->withInput();
        }

        dispatch(new SendMailToAllSubscribers(
            $request->subject,
            $request->reply_to,
            $request->message
        ));

        toastr()->success(d_trans('The email has been sent successfully'));
        return back();
    }

    public function export(Request $request)
    {
        if (NewsletterSubscriber::count() < 1) {
            toastr()->error(d_trans('You do not have any subscribers'));
            return back();
        }

        $filename = 'newsletter-subscribers-' . time() . '.xlsx';
        return Excel::download(new NewsletterSubscribersExport, $filename);
    }

    public function destroy(NewsletterSubscriber $newsletterSubscriber)
    {
        $newsletterSubscriber->delete();

        toastr()->success(d_trans('Deleted successfully'));
        return back();
    }

    public function settings()
    {
        return view('admin.newsletter.settings');
    }

    public function settingsUpdate(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'newsletter.popup_image' => ['nullable', 'image', 'mimes:jpeg,jpg,png'],
            'newsletter.popup_reminder_time' => ['required', 'integer', 'min:1', 'max:8760'],
        ]);

        if ($validator->fails()) {
            foreach ($validator->errors()->all() as $error) {
                toastr()->error($error);
            }
            return back();
        }

        $requestData = $request->except('_token');
        $newsletter = $requestData['newsletter'];

        try {
            if ($request->hasFile('newsletter.popup_image')) {
                $image = FileHandler::upload($request->file('newsletter.popup_image'), [
                    'path' => 'images/newsletter/',
                    'old_file' => config('settings.newsletter.popup_image'),
                ]);
                $newsletter['popup_image'] = $image;
            } else {
                $newsletter['popup_image'] = config('settings.newsletter.popup_image');
            }
        } catch (Exception $e) {
            toastr()->error($e->getMessage());
            return back()->withInput();
        }

        $newsletter['status'] = ($request->has('newsletter.status')) ? 1 : 0;
        $newsletter['popup_status'] = ($request->has('newsletter.popup_status')) ? 1 : 0;
        $newsletter['footer_status'] = ($request->has('newsletter.footer_status')) ? 1 : 0;
        $newsletter['register_new_users'] = ($request->has('newsletter.register_new_users')) ? 1 : 0;

        $update = Setting::updateSettings('newsletter', $newsletter);
        if (!$update) {
            toastr()->error(d_trans('Updated Error'));
            return back();
        }

        toastr()->success(d_trans('Updated Successfully'));
        return back();
    }
}
