<?php

namespace App\Listeners\Admin;

use App\Events\KycVerificationPending;
use App\Jobs\Admin\SendKycPendingNotification;
use App\Models\Admin;

class ProcessPendingKycVerification
{
    public function handle(KycVerificationPending $event)
    {
        $kycVerification = $event->kycVerification;

        $admins = Admin::all();
        foreach ($admins as $admin) {
            dispatch(new SendKycPendingNotification($admin, $kycVerification));
        }

        $title = d_trans('KYC Verification Request [#:kyc_verification_id]', ['kyc_verification_id' => $kycVerification->id]);
        $image = asset('images/notifications/kyc.png');
        $link = route('admin.kyc-verifications.show', $kycVerification->id);
        adminNotify($title, $image, $link);
    }
}