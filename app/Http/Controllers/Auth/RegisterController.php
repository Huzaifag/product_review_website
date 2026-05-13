<?php

namespace App\Http\Controllers\Auth;

use App\Classes\ReCaptcha;
use App\Events\Registered;
use App\Http\Controllers\Controller;
use App\Models\Plan;
use App\Models\User;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Log;

class RegisterController extends Controller
{
    use RegistersUsers;

    protected $redirectTo;

    public function __construct()
    {
        $this->middleware('guest');
        $this->redirectTo = config('system.user.redirect_to');
    }

    public function showRegistrationForm(Request $request)
    {
        return theme_view('auth.register');
    }

    protected function validator(array $data)
    {
        $rules = [
            'email' => ['required', 'string', 'email', 'block_patterns', 'indisposable', 'max:100', 'unique:users'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ] + app(ReCaptcha::class)->validate();

        if (config('settings.links.terms_of_use_link')) {
            $rules['terms'] = ['required'];
        }

        return Validator::make($data, $rules);
    }

    public function register(Request $request)
    {
        $data = $request->all();
        $this->validator($data)->validate();

        $user = $this->create($data);
        event(new Registered($user));

        try {
            $user->emailVerification();
        } catch (\Exception $e) {
            Log::error('Failed to send verification email to '.$user->email.': '.$e->getMessage());
        }

        Log::info('User registered successfully: '.$user->email);

        $this->createSubscription($user);

        toastr()->success(d_trans('Registration successful! Please check your email to verify your account before logging in.'));

        return $this->registered($request, $user)
            ?: redirect()->route('login');
    }

    protected function create(array $data)
    {
        $username = strtolower(strstr($data['email'], '@', true));

        $user = User::create([
            'username' => $username,
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
        ]);

        $user->pushLog();
        self::adminNotify($user);

        return $user;
    }

    public function verified(Request $request, $id, $hash)
    {
        $user = User::findOrFail($id);

        if (! hash_equals((string) $hash, sha1($user->getEmailForVerification()))) {
            abort(403);
        }

        if (! $user->isEmailVerified()) {
            $user->email_verified_at = now();
            $user->save();
        }

        toastr()->success(d_trans('Email verified successfully! You can now log in.'));

        return redirect()->route('login');
    }

    // create user subscription with free plan

    private function createSubscription($user)
    {
        $plan = Plan::getFreePlan();
        if ($plan) {
            $user->subscriptions()->create([
                'plan_id' => $plan->id,
                'status' => 'active',
            ]);
        }
    }

    public static function adminNotify($user)
    {
        $title = d_trans(':username has registered', ['username' => $user->getName()]);
        $image = $user->getAvatar();
        $link = route('admin.members.users.edit', $user->id);

        return adminNotify($title, $image, $link);
    }
}
