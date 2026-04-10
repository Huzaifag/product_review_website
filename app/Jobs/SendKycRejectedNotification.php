<?php

namespace App\Jobs;

use App\Classes\SendMail;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;

class SendKycRejectedNotification implements ShouldQueue
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

        SendMail::send($guard->email, 'kyc_verification_rejected', [
            'name' => $guard->getName(),
            'rejection_reason' => $kycVerification->rejection_reason,
            'website_name' => m_trans(config('settings.general.site_name')),
        ]);
    }
}
