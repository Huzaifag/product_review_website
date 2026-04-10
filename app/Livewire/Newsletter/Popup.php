<?php

namespace App\Livewire\Newsletter;

use App\Classes\Newsletter;
use App\Traits\LivewireToastr;
use Exception;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\Validator;
use Livewire\Component;

class Popup extends Component
{
    use LivewireToastr;

    public $email;

    public function remindLater()
    {
        Cookie::queue('newsletter_reminder', true, (config('settings.newsletter.popup_reminder_time') * 60));
        $this->dispatch('close-modal', id: 'newsletterModal');
    }

    public function subscribe()
    {
        $validator = Validator::make(['email' => $this->email], [
            'email' => ['required', 'string', 'email', 'block_patterns', 'indisposable'],
        ]);

        if ($validator->fails()) {
            foreach ($validator->errors()->all() as $error) {
                return $this->toastr('error', $error);
            }
        }

        try {
            if (!Newsletter::isSubscribed($this->email)) {
                Newsletter::subscribe($this->email);
            }

            Cookie::queue(Cookie::forever('newsletter_subscribed', true));

            $this->email = '';
            $this->dispatch('close-modal', id: 'newsletterModal');
            $this->dispatch('newsletterRefresh');

            return $this->toastr('success', d_trans('You have successfully subscribed'));
        } catch (Exception $e) {
            return $this->toastr('error', $e->getMessage());
        }
    }

    public function render()
    {
        $newsletterPopupStatus = config('settings.newsletter.status') && config('settings.newsletter.popup_status')
        && !request()->hasCookie('newsletter_subscribed') && !request()->hasCookie('newsletter_reminder');

        return theme_view('livewire.newsletter.popup', [
            'newsletterPopupStatus' => $newsletterPopupStatus,
        ]);
    }
}