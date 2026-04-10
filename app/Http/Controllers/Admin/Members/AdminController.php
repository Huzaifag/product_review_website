<?php

namespace App\Http\Controllers\Admin\Members;

use App\Handlers\FileHandler;
use App\Http\Controllers\Controller;
use App\Models\Admin;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class AdminController extends Controller
{
    public function index()
    {
        $admins = Admin::where('id', '!=', authAdmin()->id);

        if (request()->filled('search')) {
            $searchTerm = '%' . request('search') . '%';
            $admins->where('firstname', 'like', $searchTerm)
                ->OrWhere('lastname', 'like', $searchTerm)
                ->OrWhere('username', 'like', $searchTerm)
                ->OrWhere('email', 'like', $searchTerm);
        }

        $admins = $admins->orderbyDesc('id')->paginate(50);
        $admins->appends(request()->only(['search']));

        return view('admin.members.admins.index', ['admins' => $admins]);
    }

    public function create()
    {
        return view('admin.members.admins.create');
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'firstname' => ['required', 'string', 'block_patterns', 'max:50'],
            'lastname' => ['required', 'string', 'block_patterns', 'max:50'],
            'username' => ['required', 'string', 'min:3', 'max:50', 'alpha_dash', 'block_patterns', 'unique:admins'],
            'email' => ['required', 'email', 'string', 'block_patterns', 'indisposable', 'max:100', 'unique:admins'],
            'password' => ['required', 'string', 'min:8'],
        ]);

        if ($validator->fails()) {
            foreach ($validator->errors()->all() as $error) {
                toastr()->error($error);
            }
            return back()->withInput();
        }

        $admin = new Admin();
        $admin->firstname = $request->firstname;
        $admin->lastname = $request->lastname;
        $admin->username = $request->username;
        $admin->email = $request->email;
        $admin->password = Hash::make($request->password);
        $admin->save();

        toastr()->success(d_trans('Created Successfully'));
        return redirect()->route('admin.members.admins.edit', $admin->id);
    }

    public function edit(Admin $admin)
    {
        return view('admin.members.admins.edit', ['admin' => $admin]);
    }

    public function update(Request $request, Admin $admin)
    {
        $validator = Validator::make($request->all(), [
            'avatar' => ['nullable', 'image', 'mimes:png,jpg,jpeg', 'max:2048'],
            'firstname' => ['required', 'string', 'block_patterns', 'max:50'],
            'lastname' => ['required', 'string', 'block_patterns', 'max:50'],
            'username' => ['required', 'string', 'min:3', 'max:50', 'alpha_dash', 'block_patterns', 'unique:admins,username,' . $admin->id],
            'email' => ['required', 'email', 'string', 'block_patterns', 'indisposable', 'max:100', 'unique:admins,email,' . $admin->id],
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
                    'path' => 'images/avatars/admins/',
                    'size' => '120x120',
                    'old_file' => $admin->avatar,
                ]);
            } else {
                $avatar = $admin->avatar;
            }
        } catch (Exception $e) {
            toastr()->error($e->getMessage());
            return back();
        }

        $admin->firstname = $request->firstname;
        $admin->lastname = $request->lastname;
        $admin->username = $request->username;
        $admin->email = $request->email;
        $admin->avatar = $avatar;
        $admin->update();

        toastr()->success(d_trans('Updated Successfully'));
        return back();
    }

    public function sendMail(Admin $admin)
    {
        return view('admin.members.admins.sendmail', ['admin' => $admin]);
    }

    public function sendMailSend(Request $request, Admin $admin)
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
            $email = $admin->email;
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

    public function password(Admin $admin)
    {
        return view('admin.members.admins.password', ['admin' => $admin]);
    }

    public function passwordUpdate(Request $request, Admin $admin)
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

        $admin->password = Hash::make($request->get('new_password'));
        $admin->update();

        toastr()->success(d_trans('Updated Successfully'));
        return back();
    }

    public function actions(Admin $admin)
    {
        return view('admin.members.admins.actions', ['admin' => $admin]);
    }

    public function actionsUpdate(Request $request, Admin $admin)
    {
        $twoFactorStatus = Admin::TWO_FACTOR_DISABLED;
        if ($request->has('two_factor_status')) {
            if ($admin->isTwoFactorDisabled()) {
                toastr()->error(d_trans('Two-Factor authentication cannot activated from admin side'));
                return back();
            } else {
                $twoFactorStatus = Admin::TWO_FACTOR_ACTIVE;
            }
        }

        $admin->two_factor_status = $twoFactorStatus;
        $admin->update();

        toastr()->success(d_trans('Updated Successfully'));
        return back();
    }

    public function destroy(Admin $admin)
    {
        FileHandler::delete($admin->avatar);

        $admin->delete();
        toastr()->success(d_trans('Deleted Successfully'));
        return back();
    }
}