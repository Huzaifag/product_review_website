<?php

namespace App\Jobs\Admin;

use App\Classes\SendMail;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;

class SendKycPendingNotification implements ShouldQueue
{
    use Queueable;

    public $admin;
    public $kycVerification;

    public function __construct($admin, $kycVerification)
    {
        $this->admin = $admin;
        $this->kycVerification = $kycVerification;
    }

    public function handle()
    {
        $admin = $this->admin;
        $kycVerification = $this->kycVerification;

        SendMail::send($admin->email, 'admin_kyc_pending', [
            "name" => $kycVerification->guard->getName(),
            "kyc_verification_id" => $kycVerification->id,
            "view_link" => route('admin.kyc-verifications.show', $kycVerification->id),
            "website_name" => m_trans(config('settings.general.site_name')),
        ]);
    }
}