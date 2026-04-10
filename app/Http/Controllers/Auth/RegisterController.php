<?php

namespace App\Http\Controllers\Auth;

use App\Classes\ReCaptcha;
use App\Events\Registered;
use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

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

        event(new Registered($user = $this->create($data)));
        $this->guard()->login($user);

        return $this->registered($request, $user)
        ?: redirect($this->redirectPath());
    }

    protected function create(array $data)
    {
        $username = generateUniqueUsername($data['email']);

        $user = User::create([
            'username' => $username,
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
        ]);

        $user->pushLog();
        self::adminNotify($user);

        return $user;
    }

    public static function adminNotify($user)
    {
        $title = d_trans(':username has registered', ['username' => $user->getName()]);
        $image = $user->getAvatar();
        $link = route('admin.members.users.edit', $user->id);
        return adminNotify($title, $image, $link);
    }
}