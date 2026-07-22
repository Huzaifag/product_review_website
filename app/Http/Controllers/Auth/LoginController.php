<?php

namespace App\Http\Controllers\Auth;

use App\Classes\ReCaptcha;
use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Laravel\Socialite\Facades\Socialite;

class LoginController extends Controller
{
    use AuthenticatesUsers;

    protected $redirectTo;

    public function __construct()
    {
        $this->middleware('guest')->except('logout');
        $this->redirectTo = config('system.user.redirect_to');
    }

    public function showLoginForm()
    {
        return theme_view('auth.login');
    }

    protected function validateLogin(Request $request)
    {
        $request->validate([
            $this->username() => 'required|string',
            'password' => 'required|string',
        ] + app(ReCaptcha::class)->validate());
    }

    protected function authenticated(Request $request, $user)
    {
        if ($user->isBanned()) {
            Auth::logout();
            toastr()->error(d_trans('Your account has been banned'));

            return redirect()->route('login');
        }

        if (! $user->isEmailVerified()) {
            Auth::logout();
            toastr()->error(d_trans('Please verify your email address before logging in.'));

            return redirect()->route('login');
        }

        $user->pushLog();
    }

    protected function attemptLogin(Request $request)
    {
        $username = $request->input($this->username());
        $field = filter_var($username, FILTER_VALIDATE_EMAIL) ? 'email' : 'username';

        return $this->guard()->attempt([
            $field => $username,
            'password' => $request->input('password'),
        ],
            $request->filled('remember')
        );
    }

    //Google Auth

    public function redirectToGoogle()
    {
        return Socialite::driver('google')->redirect();
    }

    public function handleGoogleCallback()
    {
        $googleUser = Socialite::driver('google')->stateless()->user();

        $user = User::updateOrCreate(
            [
                'email' => $googleUser->email,
            ],
            [
                'name' => $googleUser->name,
                'google_id' => $googleUser->id,
                'password' => bcrypt(str()->random(16)),
            ]
        );

        Auth::login($user);

        return redirect('/');
    }

    public function logout(Request $request)
    {
        $sessionKey = $this->guard()->getName();

        $this->guard()->logout();

        $request->session()->forget($sessionKey);

        if ($response = $this->loggedOut($request)) {
            return $response;
        }

        return $request->wantsJson()
        ? new JsonResponse([], 204)
        : redirect($this->redirectTo);
    }

    public function username()
    {
        return 'email_or_username';
    }
}
