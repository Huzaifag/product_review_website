<?php

namespace App\Livewire\Newsletter;

use App\Classes\Newsletter;
use App\Traits\LivewireToastr;
use Exception;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\Validator;
use Livewire\Component;

class Footer extends Component
{
    use LivewireToastr;

    public $hasSocialLinks;

    public $email;

    protected $listeners = [
        'newsletterRefresh' => '$refresh',
    ];

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
            $this->dispatch('newsletterRefresh');

            return $this->toastr('success', d_trans('You have successfully subscribed'));
        } catch (Exception $e) {
            return $this->toastr('error', $e->getMessage());
        }
    }

    public function render()
    {
        $newsletterFooterStatus = config('settings.newsletter.status')
        && config('settings.newsletter.footer_status') && !request()->hasCookie('newsletter_subscribed');

        return theme_view('livewire.newsletter.footer', [
            'newsletterFooterStatus' => $newsletterFooterStatus,
        ]);
    }
}