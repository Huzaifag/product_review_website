<?php

namespace App\Http\Controllers\Business\Auth;

use App\Classes\ReCaptcha;
use App\Events\Registered;
use App\Http\Controllers\Business\EmployeeController;
use App\Http\Controllers\Controller;
use App\Models\BusinessEmployee;
use App\Models\BusinessOwner;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class RegisterController extends Controller
{
    use RegistersUsers;

    protected $redirectTo;

    public function __construct()
    {
        $this->middleware('guest:business_owner')->except('logout');
        $this->redirectTo = config('system.business.path');
    }

    public function showRegistrationForm(Request $request)
    {
        return theme_view('business.auth.register');
    }

    protected function validator(array $data)
    {
        $rules = [
            'firstname' => ['required', 'string', 'block_patterns', 'max:50'],
            'lastname' => ['required', 'string', 'block_patterns', 'max:50'],
            'username' => ['required', 'string', 'min:3', 'max:50', 'username', 'alpha_dash', 'block_patterns', 'unique:business_owners'],
            'email' => ['required', 'string', 'email', 'block_patterns', 'indisposable', 'max:100', 'unique:business_owners'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ] + app(ReCaptcha::class)->validate();

        if (config('settings.links.terms_of_use_link')) {
            $rules['terms'] = ['required'];
        }

        if (config('settings.links.business_terms_link')) {
            $rules['business_terms'] = ['required'];
        }

        return Validator::make($data, $rules);
    }

    public function register(Request $request)
    {
        $data = $request->all();
        $this->validator($data)->validate();

        event(new Registered($businessOwner = $this->create($request, $data)));
        $this->guard()->login($businessOwner);

        $this->registered($request, $businessOwner);

        if ($request->filled('claimed_business')) {
            return redirect()->route('business.claim.index', $request->claimed_business);
        }

        return redirect($this->redirectTo);
    }

    protected function create(Request $request, array $data)
    {
        $businessOwner = BusinessOwner::create([
            'firstname' => $data['firstname'],
            'lastname' => $data['lastname'],
            'username' => $data['username'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
        ]);

        self::attachBusiness($request, $businessOwner);

        $businessOwner->pushLog();

        self::adminNotify($businessOwner);

        return $businessOwner;
    }

    public static function attachBusiness(Request $request, $businessOwner)
    {
        if ($request->filled('invitation_token')) {
            $businessEmployee = BusinessEmployee::where('token', $request->invitation_token)->first();
            if ($businessEmployee && $businessOwner->email == $businessEmployee->email) {
                EmployeeController::attachEmployeeWithBusiness($businessOwner, $businessEmployee);
            }
        }
    }

    public static function adminNotify($businessOwner)
    {
        $title = d_trans(':username has registered', ['username' => $businessOwner->getName()]);
        $image = $businessOwner->getAvatar();
        $link = route('admin.members.business-owners.edit', $businessOwner->id);
        return adminNotify($title, $image, $link);
    }

    protected function guard()
    {
        return Auth::guard('business_owner');
    }
}
