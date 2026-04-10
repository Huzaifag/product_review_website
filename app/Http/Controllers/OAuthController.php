<?php

namespace App\Http\Controllers;

use App\Events\Registered;
use App\Models\BusinessOwner;
use App\Models\OAuthProvider;
use App\Models\User;
use Carbon\Carbon;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Laravel\Socialite\Facades\Socialite;

class OAuthController extends Controller
{
    public $guards = ['user', 'business_owner'];

    public function redirectToProvider($provider, $guard)
    {
        abort_if(!in_array($guard, $this->guards), 401);

        $oauthProvider = OAuthProvider::where('alias', $provider)->firstOrFail();

        session(['oauth_guard' => $guard]);

        return Socialite::driver($oauthProvider->alias)->redirect();
    }

    public function handleProviderCallback(Request $request, $provider)
    {
        $guard = session('oauth_guard');
        abort_if(!$guard, 401);

        $redirect = $guard == $this->guards[1] ? route('business.login') : route('login');

        try {
            $oauthProvider = OAuthProvider::where('alias', $provider)->firstOrFail();
            $socialUser = Socialite::driver($oauthProvider->alias)->user();

            $method = 'handle' . Str::studly($guard) . 'CallBack';
            $redirect = $this->{$method}($oauthProvider, $socialUser);

            return redirect($redirect);
        } catch (\Exception $e) {
            toastr()->error($e->getMessage());
            return redirect($redirect);
        }
    }

    public function handleUserCallBack($oauthProvider, $socialUser)
    {
        try {
            if (!config('settings.user.actions.registration')) {
                throw new Exception(d_trans('Registration is currently disabled.'));
            }

            $id = $socialUser->getId();
            $name = explode(' ', $socialUser->getName());
            $email = $socialUser->getEmail();

            $redirect = config('system.user.redirect_to');

            $userExists = User::where($oauthProvider->alias . '_id', $id)->first();
            if ($userExists) {
                Auth::login($userExists);
                $userExists->pushLog();
                return redirect($redirect);
            }

            if ($email) {
                $emailExists = User::where('email', $email)->first();
                if ($emailExists) {
                    $email = null;
                }
            }

            $username = generateUniqueUsername($email);

            $user = User::create([
                'firstname' => $name[0] ?? null,
                'lastname' => $name[1] ?? null,
                'username' => $username,
                'email' => $email,
                $oauthProvider->alias . '_id' => $id,
            ]);

            if ($user) {
                if ($user->email) {
                    $user->forceFill(['email_verified_at' => Carbon::now()])->save();
                }
                event(new Registered($user));
                Auth::login($user);
                $user->pushLog();
                $user->adminNotify($user);

                return $redirect;
            }
        } catch (Exception $e) {
            throw new Exception($e->getMessage());
        }
    }

    public function handleBusinessOwnerCallBack($oauthProvider, $socialUser)
    {
        try {
            if (!config('settings.business.actions.owners_registration')) {
                throw new Exception(d_trans('Registration is currently disabled.'));
            }

            $id = $socialUser->getId();
            $name = explode(' ', $socialUser->getName());
            $email = $socialUser->getEmail();

            $redirect = config('system.business.path');

            $businessOwnerExists = BusinessOwner::where($oauthProvider->alias . '_id', $id)->first();
            if ($businessOwnerExists) {
                Auth::guard('business_owner')->login($businessOwnerExists);
                $businessOwnerExists->pushLog();
                return redirect($redirect);
            }

            if ($email) {
                $emailExists = BusinessOwner::where('email', $email)->first();
                if ($emailExists) {
                    $email = null;
                }
            }

            $username = generateUniqueUsername($email);

            $businessOwner = BusinessOwner::create([
                'firstname' => $name[0] ?? null,
                'lastname' => $name[1] ?? null,
                'username' => $username,
                'email' => $email,
                $oauthProvider->alias . '_id' => $id,
            ]);

            if ($businessOwner) {
                if ($businessOwner->email) {
                    $businessOwner->forceFill(['email_verified_at' => Carbon::now()])->save();
                }
                event(new Registered($businessOwner));
                Auth::guard('business_owner')->login($businessOwner);
                $businessOwner->pushLog();
                // $businessOwner->adminNotify($businessOwner);

                return $redirect;
            }
        } catch (Exception $e) {
            throw new Exception($e->getMessage());
        }
    }
}