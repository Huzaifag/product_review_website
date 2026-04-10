<?php

namespace App\Http\Controllers\Admin\Members;

use App\Classes\Country;
use App\Handlers\FileHandler;
use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\UserLoginLog;
use Carbon\Carbon;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{
    public function index()
    {
        $counters['active'] = User::active()->count();
        $counters['banned'] = User::banned()->count();
        $counters['email_verified'] = User::emailVerified()->count();
        $counters['email_unverified'] = User::emailUnVerified()->count();
        $counters['kyc_verified'] = User::kycVerified()->count();
        $counters['kyc_unverified'] = User::kycUnverified()->count();

        $users = User::query();

        if (request()->filled('search')) {
            $searchTerm = '%' . request('search') . '%';
            $users->where(function ($query) use ($searchTerm) {
                $query->where('firstname', 'like', $searchTerm)
                    ->orWhere('lastname', 'like', $searchTerm)
                    ->orWhere('username', 'like', $searchTerm)
                    ->orWhere('email', 'like', $searchTerm)
                    ->orWhere('country', 'like', $searchTerm)
                    ->orWhere('facebook_id', 'like', $searchTerm)
                    ->orWhere('google_id', 'like', $searchTerm)
                    ->orWhere('microsoft_id', 'like', $searchTerm)
                    ->orWhere('vkontakte_id', 'like', $searchTerm);
            });
        }

        if (request()->filled('email_status')) {
            if (request('email_status') == 1) {
                $users->whereNotNull('email_verified_at');
            } else {
                $users->whereNull('email_verified_at');
            }
        }

        if (request()->filled('kyc_status')) {
            $users->where('kyc_status', request('kyc_status'));
        }

        if (request()->filled('account_status')) {
            $users->where('status', request('account_status'));
        }

        $users = $users->orderbyDesc('id')->paginate(50);
        $users->appends(request()->only(['search', 'account_status', 'email_status']));

        return view('admin.members.users.index', [
            'counters' => $counters,
            'users' => $users,
        ]);
    }

    public function login(User $user)
    {
        Auth::login($user);
        return redirect(config('system.user.redirect_to'));
    }

    public function create()
    {
        return view('admin.members.users.create');
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'firstname' => ['nullable', 'string', 'block_patterns', 'max:50'],
            'lastname' => ['nullable', 'string', 'block_patterns', 'max:50'],
            'username' => ['required', 'string', 'username', 'min:3', 'max:50', 'alpha_dash', 'block_patterns', 'unique:users'],
            'email' => ['required', 'email', 'string', 'block_patterns', 'indisposable', 'max:100', 'unique:users'],
            'password' => ['required', 'string', 'min:8'],
        ]);

        if ($validator->fails()) {
            foreach ($validator->errors()->all() as $error) {
                toastr()->error($error);
            }
            return back()->withInput();
        }

        $user = new User();
        $user->firstname = $request->firstname;
        $user->lastname = $request->lastname;
        $user->username = $request->username;
        $user->email = $request->email;
        $user->password = Hash::make($request->password);
        $user->save();

        $user->sendEmailVerificationNotification();

        toastr()->success(d_trans('Created Successfully'));
        return redirect()->route('admin.members.users.edit', $user->id);

    }

    public function edit(User $user)
    {
        return view('admin.members.users.edit', $this->sharedData($user));
    }

    public function update(Request $request, User $user)
    {
        $validator = Validator::make($request->all(), [
            'avatar' => ['nullable', 'image', 'mimes:png,jpg,jpeg', 'max:2048'],
            'firstname' => ['nullable', 'string', 'block_patterns', 'max:50'],
            'lastname' => ['nullable', 'string', 'block_patterns', 'max:50'],
            'username' => ['required', 'string', 'username', 'min:3', 'max:50', 'alpha_dash', 'block_patterns', 'unique:users,username,' . $user->id],
            'email' => ['required', 'email', 'string', 'block_patterns', 'indisposable', 'max:100', 'unique:users,email,' . $user->id],
            'country' => ['nullable', 'string', 'block_patterns', 'in:' . implode(',', array_keys(Country::all()))],
        ]);

        if ($validator->fails()) {
            foreach ($validator->errors()->all() as $error) {
                toastr()->error($error);
            }
            return back();
        }

        try {
            if ($request->has('avatar')) {
                $avatar = FileHandler::upload($request->file('avatar'), [
                    'path' => 'images/avatars/users/',
                    'size' => '120x120',
                    'old_file' => $user->avatar,
                ]);
            } else {
                $avatar = $user->avatar;
            }
        } catch (Exception $e) {
            toastr()->error($e->getMessage());
            return back();
        }

        $user->firstname = $request->firstname;
        $user->lastname = $request->lastname;
        $user->username = $request->username;
        $user->email = $request->email;
        $user->country = $request->country;
        $user->avatar = $avatar;
        $user->update();

        toastr()->success(d_trans('Updated Successfully'));
        return back();
    }

    public function password(User $user)
    {
        return view('admin.members.users.password', $this->sharedData($user));
    }

    public function passwordUpdate(Request $request, User $user)
    {
        $validator = Validator::make($request->all(), [
            'new_password' => ['required', 'string', 'min:6', 'confirmed'],
            'new_password_confirmation' => ['required'],
        ]);

        if ($validator->fails()) {
            foreach ($validator->errors()->all() as $error) {
                toastr()->error($error);
            }
            return back();
        }

        $user->password = Hash::make($request->get('new_password'));
        $user->update();

        toastr()->success(d_trans('Updated Successfully'));
        return back();
    }

    public function logs(User $user)
    {
        $loginLogs = UserLoginLog::where('user_id', $user->id);

        if (request()->filled('search')) {
            $searchTerm = '%' . request('search') . '%';
            $loginLogs->where(function ($query) use ($searchTerm) {
                $query->where('ip', 'like', $searchTerm)
                    ->orWhere('country', 'like', $searchTerm)
                    ->orWhere('country_code', 'like', $searchTerm)
                    ->orWhere('timezone', 'like', $searchTerm)
                    ->orWhere('location', 'like', $searchTerm)
                    ->orWhere('latitude', 'like', $searchTerm)
                    ->orWhere('longitude', 'like', $searchTerm)
                    ->orWhere('browser', 'like', $searchTerm)
                    ->orWhere('os', 'like', $searchTerm);
            });
        }

        $loginLogs = $loginLogs->orderbyDesc('id')->paginate(20);
        $loginLogs->appends(request()->only(['search']));

        return view('admin.members.users.logs', $this->sharedData($user) + [
            'loginLogs' => $loginLogs,
        ]);
    }

    public function logDelete(User $user, UserLoginLog $userLoginLog)
    {
        $userLoginLog->delete();
        toastr()->success(d_trans('Deleted Successfully'));
        return back();
    }

    public function sendMail(User $user)
    {
        return view('admin.members.users.sendmail', $this->sharedData($user));
    }

    public function sendMailSend(Request $request, User $user)
    {
        $validator = Validator::make($request->all(), [
            'subject' => ['required', 'string', 'block_patterns'],
            'reply_to' => ['required', 'email', 'block_patterns'],
            'message' => ['required', 'string'],
        ]);

        if ($validator->fails()) {
            foreach ($validator->errors()->all() as $error) {
                toastr()->error($error);
            }
            return back();
        }

        if (!config('settings.smtp.status')) {
            toastr()->error(d_trans('SMTP is not enabled'));
            return back()->withInput();
        }

        try {
            $email = $user->email;
            $subject = $request->subject;
            $replyTo = $request->reply_to;
            $msg = $request->message;

            \Mail::send([], [], function ($message) use ($msg, $email, $subject, $replyTo) {
                $message->to($email)
                    ->replyTo($replyTo)
                    ->subject($subject)
                    ->html($msg);
            });

            toastr()->success(d_trans('Sent successfully'));
            return back();
        } catch (\Exception $e) {
            toastr()->error(d_trans('Sent error'));
            return back();
        }
    }

    public function actions(User $user)
    {
        return view('admin.members.users.actions', $this->sharedData($user));
    }

    public function actionsUpdate(Request $request, User $user)
    {
        $request->status = ($request->has('status')) ? User::STATUS_ACTIVE : User::STATUS_BANNED;

        $request->kyc_status = $request->has('kyc_status') ? User::KYC_STATUS_VERIFIED : User::KYC_STATUS_UNVERIFIED;

        $twoFactorStatus = User::TWO_FACTOR_DISABLED;
        if ($request->has('two_factor_status')) {
            if ($user->isTwoFactorDisabled()) {
                toastr()->error(d_trans('Two-Factor authentication cannot activated from admin side'));
                return back();
            } else {
                $twoFactorStatus = User::TWO_FACTOR_ACTIVE;
            }
        }

        $user->kyc_status = $request->kyc_status;
        $user->two_factor_status = $twoFactorStatus;
        $user->status = $request->status;
        $user->update();

        $emailVerifiedAt = ($request->has('email_status')) ? Carbon::now() : null;
        $user->forceFill(['email_verified_at' => $emailVerifiedAt])->save();

        toastr()->success(d_trans('Updated Successfully'));
        return back();
    }

    public function destroy(User $user)
    {
        FileHandler::delete($user->avatar);

        $user->delete();
        toastr()->success(d_trans('Deleted Successfully'));
        return back();
    }

    private function sharedData($user)
    {
        $counters['total_reviews'] = $user->total_reviews;
        $counters['total_review_reports'] = $user->reports()->count();
        $counters['total_pending_reviews'] = $user->reviews()->pending()->count();

        return [
            'user' => $user,
            'counters' => $counters,
        ];
    }
}