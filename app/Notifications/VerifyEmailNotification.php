<?php

namespace App\Notifications;

use App\Classes\SendMail;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\URL;

class VerifyEmailNotification extends Notification
{
    use Queueable;

    public $route;

    public static $createUrlCallback;

    public static $toMailCallback;

    public function __construct($route)
    {
        $this->route = $route;
    }

    public function via($notifiable)
    {
        return ['mail'];
    }

    public function toMail($notifiable)
    {
        $mailTemplate = mailTemplate('email_verification');

        $shortCodes = [
            'link' => $this->verificationUrl($notifiable),
            'website_name' => m_trans(config('settings.general.site_name')),
        ];

        $subject = SendMail::replaceShortCodes($mailTemplate->subject, $shortCodes);
        $body = SendMail::replaceShortCodes($mailTemplate->body, $shortCodes);

        return (new MailMessage)->subject($subject)
            ->markdown('emails.default', ['body' => $body]);
    }

    protected function verificationUrl($notifiable)
    {
        if (static::$createUrlCallback) {
            return call_user_func(static::$createUrlCallback, $notifiable);
        }

        return URL::temporarySignedRoute(
            $this->route,
            Carbon::now()->addMinutes(Config::get('auth.verification.expire', 60)),
            [
                'id' => $notifiable->getKey(),
                'hash' => sha1($notifiable->getEmailForVerification()),
            ]
        );
    }
}
