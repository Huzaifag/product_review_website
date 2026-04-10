<?php

namespace App\Http\Controllers\Admin\Members;

use App\Classes\Country;
use App\Handlers\FileHandler;
use App\Http\Controllers\Controller;
use App\Models\BusinessOwner;
use App\Models\BusinessOwnerLoginLog;
use Carbon\Carbon;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class BusinessOwnerController extends Controller
{
    public function index()
    {
        $counters['active'] = BusinessOwner::active()->count();
        $counters['banned'] = BusinessOwner::banned()->count();
        $counters['email_verified'] = BusinessOwner::emailVerified()->count();
        $counters['email_unverified'] = BusinessOwner::emailUnVerified()->count();
        $counters['kyc_verified'] = BusinessOwner::kycVerified()->count();
        $counters['kyc_unverified'] = BusinessOwner::kycUnverified()->count();

        $owners = BusinessOwner::query();

        if (request()->filled('search')) {
            $searchTerm = '%' . request('search') . '%';
            $owners->where(function ($query) use ($searchTerm) {
                $query->where('firstname', 'like', $searchTerm)
                    ->orWhere('lastname', 'like', $searchTerm)
                    ->orWhere('username', 'like', $searchTerm)
                    ->orWhere('email', 'like', $searchTerm)
                    ->orWhere('address', 'like', $searchTerm)
                    ->orWhere('facebook_id', 'like', $searchTerm)
                    ->orWhere('google_id', 'like', $searchTerm)
                    ->orWhere('microsoft_id', 'like', $searchTerm)
                    ->orWhere('vkontakte_id', 'like', $searchTerm);
            });
        }

        if (request()->filled('email_status')) {
            if (request('email_status') == 1) {
                $owners->whereNotNull('email_verified_at');
            } else {
                $owners->whereNull('email_verified_at');
            }
        }

        if (request()->filled('kyc_status')) {
            $owners->where('kyc_status', request('kyc_status'));
        }

        if (request()->filled('account_status')) {
            $owners->where('status', request('account_status'));
        }

        $owners = $owners->orderbyDesc('id')->paginate(50);
        $owners->appends(request()->only(['search', 'account_status', 'email_status']));

        return view('admin.members.business-owners.index', [
            'counters' => $counters,
            'owners' => $owners,
        ]);
    }

    public function login(BusinessOwner $businessOwner)
    {
        Auth::guard('business_owner')->login($businessOwner);
        return redirect(config('system.business.path'));
    }

    public function create()
    {
        return view('admin.members.business-owners.create');
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'firstname' => ['nullable', 'string', 'block_patterns', 'max:50'],
            'lastname' => ['nullable', 'string', 'block_patterns', 'max:50'],
            'username' => ['required', 'string', 'username', 'min:3', 'max:50', 'alpha_dash', 'block_patterns', 'unique:business_owners'],
            'email' => ['required', 'email', 'string', 'block_patterns', 'indisposable', 'max:100', 'unique:business_owners'],
            'password' => ['required', 'string', 'min:8'],
        ]);

        if ($validator->fails()) {
            foreach ($validator->errors()->all() as $error) {
                toastr()->error($error);
            }
            return back()->withInput();
        }

        $businessOwner = new BusinessOwner();
        $businessOwner->firstname = $request->firstname;
        $businessOwner->lastname = $request->lastname;
        $businessOwner->username = $request->username;
        $businessOwner->email = $request->email;
        $businessOwner->password = Hash::make($request->password);
        $businessOwner->save();

        $businessOwner->sendEmailVerificationNotification();

        toastr()->success(d_trans('Created Successfully'));
        return redirect()->route('admin.members.business-owners.edit', $businessOwner->id);
    }

    public function edit(BusinessOwner $businessOwner)
    {
        return view('admin.members.business-owners.edit', $this->sharedData($businessOwner));
    }

    public function update(Request $request, BusinessOwner $businessOwner)
    {
        $validator = Validator::make($request->all(), [
            'avatar' => ['nullable', 'image', 'mimes:png,jpg,jpeg', 'max:2048'],
            'firstname' => ['nullable', 'string', 'block_patterns', 'max:50'],
            'lastname' => ['nullable', 'string', 'block_patterns', 'max:50'],
            'username' => ['required', 'string', 'username', 'min:3', 'max:50', 'alpha_dash', 'block_patterns', 'unique:business_owners,username,' . $businessOwner->id],
            'email' => ['required', 'email', 'string', 'block_patterns', 'indisposable', 'max:100', 'unique:business_owners,email,' . $businessOwner->id],
            'address_line_1' => ['nullable', 'string', 'max:255', 'block_patterns'],
            'address_line_2' => ['nullable', 'string', 'max:255', 'block_patterns'],
            'city' => ['nullable', 'string', 'max:150', 'block_patterns'],
            'state' => ['nullable', 'string', 'max:150', 'block_patterns'],
            'zip' => ['nullable', 'string', 'max:100', 'block_patterns'],
            'country' => ['nullable', 'string', 'in:' . implode(',', array_keys(Country::all()))],
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
                    'path' => 'images/avatars/business/',
                    'size' => '120x120',
                    'old_file' => $businessOwner->avatar,
                ]);
            } else {
                $avatar = $businessOwner->avatar;
            }
        } catch (Exception $e) {
            toastr()->error($e->getMessage());
            return back();
        }

        $country = $request->country ?? null;

        $address = [
            'line_1' => $request->address_line_1,
            'line_2' => $request->address_line_2,
            'city' => $request->city,
            'state' => $request->state,
            'zip' => $request->zip,
            'country' => $country,
        ];

        $businessOwner->firstname = $request->firstname;
        $businessOwner->lastname = $request->lastname;
        $businessOwner->username = $request->username;
        $businessOwner->email = $request->email;
        $businessOwner->address = $address;
        $businessOwner->avatar = $avatar;
        $businessOwner->update();

        toastr()->success(d_trans('Updated Successfully'));
        return back();
    }

    public function password(BusinessOwner $businessOwner)
    {
        return view('admin.members.business-owners.password', $this->sharedData($businessOwner));
    }

    public function passwordUpdate(Request $request, BusinessOwner $businessOwner)
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

        $businessOwner->password = Hash::make($request->get('new_password'));
        $businessOwner->update();

        toastr()->success(d_trans('Updated Successfully'));
        return back();
    }

    public function logs(BusinessOwner $businessOwner)
    {
        $loginLogs = BusinessOwnerLoginLog::where('business_owner_id', $businessOwner->id);

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

        return view('admin.members.business-owners.logs', $this->sharedData($businessOwner) + [
            'loginLogs' => $loginLogs,
        ]);
    }

    public function logDelete(BusinessOwner $businessOwner, BusinessOwnerLoginLog $businessOwnerLoginLog)
    {
        $businessOwnerLoginLog->delete();
        toastr()->success(d_trans('Deleted Successfully'));
        return back();
    }

    public function sendMail(BusinessOwner $businessOwner)
    {
        return view('admin.members.business-owners.sendmail', $this->sharedData($businessOwner));
    }

    public function sendMailSend(Request $request, BusinessOwner $businessOwner)
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
            $email = $businessOwner->email;
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
        } catch (Exception $e) {
            toastr()->error(d_trans('Sent error'));
            return back();
        }
    }

    public function actions(BusinessOwner $businessOwner)
    {
        return view('admin.members.business-owners.actions', $this->sharedData($businessOwner));
    }

    public function actionsUpdate(Request $request, BusinessOwner $businessOwner)
    {
        $request->status = ($request->has('status')) ? BusinessOwner::STATUS_ACTIVE : BusinessOwner::STATUS_BANNED;

        $request->kyc_status = $request->has('kyc_status') ? BusinessOwner::KYC_STATUS_VERIFIED : BusinessOwner::KYC_STATUS_UNVERIFIED;

        $twoFactorStatus = BusinessOwner::TWO_FACTOR_DISABLED;
        if ($request->has('two_factor_status')) {
            if ($businessOwner->isTwoFactorDisabled()) {
                toastr()->error(d_trans('Two-Factor authentication cannot activated from admin side'));
                return back();
            } else {
                $twoFactorStatus = BusinessOwner::TWO_FACTOR_ACTIVE;
            }
        }

        $businessOwner->kyc_status = $request->kyc_status;
        $businessOwner->two_factor_status = $twoFactorStatus;
        $businessOwner->status = $request->status;
        $businessOwner->update();

        $emailVerifiedAt = ($request->has('email_status')) ? Carbon::now() : null;
        $businessOwner->forceFill(['email_verified_at' => $emailVerifiedAt])->save();

        toastr()->success(d_trans('Updated Successfully'));
        return back();
    }

    public function destroy(BusinessOwner $businessOwner)
    {
        FileHandler::delete($businessOwner->avatar);

        $businessOwner->delete();
        toastr()->success(d_trans('Deleted Successfully'));
        return back();
    }

    private function sharedData($businessOwner)
    {
        $counters['total_businesses'] = $businessOwner->businesses()->count();
        $counters['businesses_employed_at'] = $businessOwner->businesses()
            ->whereHas('employees', function ($query) use ($businessOwner) {
                $query->where('business_owners.id', $businessOwner->id);
            })->count();

        return [
            'owner' => $businessOwner,
            'counters' => $counters,
        ];
    }
}