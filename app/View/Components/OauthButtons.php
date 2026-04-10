<?php

namespace App\View\Components;

use App\Models\OAuthProvider;
use Illuminate\View\Component;

class OauthButtons extends Component
{
    public function render()
    {
        $oauthProviders = OAuthProvider::active()->get();
        $guard = request()->segment(1) == config('system.business.path') ? 'business_owner' : 'user';
        return theme_view('components.oauth-buttons', [
            'oauthProviders' => $oauthProviders,
            'guard' => $guard,
        ]);
    }
}