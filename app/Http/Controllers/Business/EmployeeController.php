<?php

namespace App\Http\Controllers\Business;

use App\BusinessRole;
use App\Classes\SendMail;
use App\Http\Controllers\Controller;
use App\Models\BusinessEmployee;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class EmployeeController extends Controller
{
    public function index()
    {
        $roles = BusinessRole::cases();
        $statuses = BusinessEmployee::getAvailableStatuses();

        $employees = BusinessEmployee::where('business_id', currentBusiness()->id)
            ->where(function ($query) {
                $query->where('business_owner_id', '!=', authBusinessOwner()->id)
                    ->orWhereNull('business_owner_id');
            });

        if (request()->filled('search')) {
            $searchTerm = "%" . request('search') . "%";
            $employees->where(function ($query) use ($searchTerm) {
                $query->where('email', 'like', $searchTerm)
                    ->orWhereHas('owner', function ($query) use ($searchTerm) {
                        $query->where('firstname', 'like', $searchTerm)
                            ->orWhere('lastname', 'like', $searchTerm)
                            ->orWhere('username', 'like', $searchTerm)
                            ->orWhere('email', 'like', $searchTerm);
                    });
            });
        }

        if (request()->filled('role')) {
            $employees->where('role', request('role'));
        }

        if (request()->filled('status')) {
            $employees->where('status', request('status'));
        }

        $employees = $employees->orderbyDesc('id')->paginate(20);
        $employees->appends(request()->only(['search', 'role', 'status']));

        return theme_view('business.employees', [
            'roles' => $roles,
            'statuses' => $statuses,
            'employees' => $employees,
        ]);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => ['required', 'email'],
            'role' => ['required', 'string', 'in:' . implode(',', BusinessRole::values())],
        ]);

        if ($validator->fails()) {
            foreach ($validator->errors()->all() as $error) {
                toastr()->error($error);
            }
            return back();
        }

        $business = currentBusiness();

        if ($request->email == $business->owner->email || $request->email == authBusinessOwner()->email) {
            toastr()->error(d_trans('You cannot add that employee'));
            return back();
        }

        $businessEmployeeExists = BusinessEmployee::where('business_id', $business->id)
            ->where(function ($query) use ($request) {
                $query->where('email', $request->email)
                    ->orWhereHas('owner', function ($ownerQuery) use ($request) {
                        $ownerQuery->where('email', $request->email);
                    });
            })
            ->exists();

        if ($businessEmployeeExists) {
            toastr()->error(d_trans('The employee is already exists'));
            return back();
        }

        $businessEmployee = new BusinessEmployee();
        $businessEmployee->email = $request->email;
        $businessEmployee->role = $request->role;
        $businessEmployee->token = Str::random(65);
        $businessEmployee->business_id = $business->id;
        $businessEmployee->save();

        SendMail::send($businessEmployee->email, 'business_employee_invitation', [
            'business_name' => $business->trans->name,
            'invitation_link' => route('business.invitation', $businessEmployee->token),
            'website_name' => m_trans(config('settings.general.site_name')),
        ]);

        toastr()->success(d_trans('The employee has been invited successfully'));
        return back();
    }

    public function destroy($id)
    {
        $business = currentBusiness();

        $employee = BusinessEmployee::where('id', $id)
            ->where('business_id', $business->id)
            ->where(function ($query) {
                $query->where('business_owner_id', '!=', authBusinessOwner()->id)
                    ->orWhereNull('business_owner_id');
            })->firstOrFail();

        if ($employee->owner) {
            $employee->owner->businesses()->detach($business->id);
        }

        $employee->delete();

        toastr()->success(d_trans('The employee has been deleted successfully'));
        return back();
    }

    public static function attachEmployeeWithBusiness($owner, $businessEmployee)
    {
        $business = $businessEmployee->business;

        if ($business->isActive()) {
            $businessExists = $owner->businesses
                ->where('id', $business->id)->isNotEmpty();

            if (!$businessExists) {
                $owner->businesses()->attach($business->id, [
                    'role' => $businessEmployee->role,
                ]);

                $businessEmployee->email = null;
                $businessEmployee->token = null;
                $businessEmployee->status = BusinessEmployee::STATUS_ACTIVE;
                $businessEmployee->business_owner_id = $owner->id;
                $businessEmployee->update();

                Cookie::queue('current_business', $business->id, 1440 * 30);
            } else {
                $businessEmployee->delete();
            }
        }
    }
}