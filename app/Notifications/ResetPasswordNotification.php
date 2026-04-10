<?php

namespace App\Notifications;

use App\Classes\SendMail;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class ResetPasswordNotification extends Notification
{
    use Queueable;

    public $token;

    public $route;

    public function __construct($token, $route)
    {
        $this->token = $token;
        $this->route = $route;
    }

    public function via($notifiable)
    {
        return ['mail'];
    }

    public function toMail($notifiable)
    {
        $mailTemplate = mailTemplate('password_reset');

        $shortCodes = [
            'link' => url(url('/') . route($this->route, ['token' => $this->token, 'email' => $notifiable->getEmailForPasswordReset()], false)),
            'expiry_time' => config('auth.passwords.' . config('auth.defaults.passwords') . '.expire'),
            'website_name' => m_trans(config('settings.general.site_name')),
        ];

        $subject = SendMail::replaceShortCodes($mailTemplate->subject, $shortCodes);
        $body = SendMail::replaceShortCodes($mailTemplate->body, $shortCodes);

        return (new MailMessage)
            ->subject($subject)
            ->markdown('emails.default', ['body' => $body]);
    }

}
