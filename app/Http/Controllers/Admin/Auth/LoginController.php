<?php

namespace App\Http\Controllers\Admin\Auth;

use App\Classes\ReCaptcha;
use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    use AuthenticatesUsers;

    public $redirectTo;

    public function __construct()
    {
        $this->middleware('guest:admin')->except('logout');
        $this->redirectTo = config('system.admin.path');
    }

    public function showLoginForm()
    {
        return view('admin.auth.login');
    }

    protected function validateLogin(Request $request)
    {
        $request->validate([
            $this->username() => 'required|string',
            'password' => 'required|string',
        ] + app(ReCaptcha::class)->validate());
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

    protected function guard()
    {
        return Auth::guard('admin');
    }
}
