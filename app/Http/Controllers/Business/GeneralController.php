<?php

namespace App\Http\Controllers\Business;

use App\Http\Controllers\Business\Auth\SetupController;
use App\Http\Controllers\Business\EmployeeController;
use App\Http\Controllers\Controller;
use App\Models\BusinessEmployee;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cookie;

class GeneralController extends Controller
{
    public function integration()
    {
        return theme_view('business.integration');
    }

    public function setDefaultBusiness($id)
    {
        $authBusinessOwner = authBusinessOwner();

        $business = $authBusinessOwner->businesses()
            ->where('businesses.id', $id)
            ->firstOrFail();

        Cookie::queue('current_business', $business->id, 1440 * 30);

        $previousUrl = url()->previous();

        if (str_contains($previousUrl, '/' . $id)) {
            return redirect()->to(str_replace('/' . $id, '', $previousUrl));
        }

        return redirect()->back();
    }

    public function addBusiness(Request $request)
    {
        try {
            SetupController::createBusiness($request);
            toastr()->success(d_trans('Business has been added successfully'));
            return back();
        } catch (\Exception $e) {
            toastr()->error($e->getMessage());
            return back()->withInput();
        }
    }

    public function employeeInvitation(Request $request, $token)
    {
        $businessEmployee = BusinessEmployee::where('token', $token)->firstOrFail();

        $owner = authBusinessOwner();
        if ($owner) {
            if ($owner->email == $businessEmployee->email) {
                EmployeeController::attachEmployeeWithBusiness($owner, $businessEmployee);
            }

            return redirect()->route('business.dashboard');
        }

        $request->session()->put('invitation_token', $token);
        return redirect()->route('business.login');
    }
}
