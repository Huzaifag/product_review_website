<?php

namespace App\Http\Controllers\Business;

use App\Http\Controllers\Controller;
use App\Models\BusinessNotification;

class NotificationController extends Controller
{
    public function index()
    {
        $notifications = BusinessNotification::where('business_id', currentBusiness()->id)
            ->orderbyDesc('id')->paginate(20);
        return theme_view('business.notifications', ['notifications' => $notifications]);
    }

    public function view($id)
    {
        $notification = BusinessNotification::where('business_id', currentBusiness()->id)
            ->where('id', $id)->firstOrFail();
        if ($notification->link) {
            $notification->status = BusinessNotification::STATUS_READ;
            $notification->update();
            return redirect($notification->link);
        }
        return back();
    }

    public function readAll()
    {
        $notifications = BusinessNotification::where('business_id', currentBusiness()->id)
            ->unread()->get();
        if ($notifications->count() > 0) {
            foreach ($notifications as $notification) {
                $notification->update(['status' => 1]);
            }
            toastr()->success(d_trans('All notifications marked as read'));
        }
        return back();
    }

    public function deleteRead()
    {
        $notifications = BusinessNotification::where('business_id', currentBusiness()->id)
            ->read()->get();
        if ($notifications->count() > 0) {
            foreach ($notifications as $notification) {
                $notification->delete();
            }
            toastr()->success(d_trans('Read notifications deleted successfully'));
        }
        return back();
    }
}
