<?php

namespace App\Jobs;

use App\Classes\SendMail;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;

class SendKycApprovedNotification implements ShouldQueue
{
    use Queueable;

    public $kycVerification;

    public function __construct($kycVerification)
    {
        $this->kycVerification = $kycVerification;
    }

    public function handle()
    {
        $kycVerification = $this->kycVerification;
        $guard = $kycVerification->guard;

        SendMail::send($guard->email, 'kyc_verification_approved', [
            'name' => $guard->getName(),
            'website_name' => m_trans(config('settings.general.site_name')),
        ]);
    }
}
