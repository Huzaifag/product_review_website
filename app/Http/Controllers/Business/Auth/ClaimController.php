<?php

namespace App\Http\Controllers\Business\Auth;

use App\BusinessRole;
use App\Http\Controllers\Controller;
use App\Models\Business;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cookie;

class ClaimController extends Controller
{
    public function index($id)
    {
        $business = Business::active()->unclaimed()
            ->where('id', hash_decode($id))->firstOrFail();

        return theme_view('business.auth.claim', [
            'business' => $business,
        ]);
    }

    public function verify(Request $request, $id)
    {
        $business = Business::active()->unclaimed()
            ->where('id', hash_decode($id))->firstOrFail();

        $authBusinessOwner = authBusinessOwner();

        if (!$authBusinessOwner->canCreateBusiness()) {
            toastr()->error(d_trans('You cannot have more businesses'));
            return back();
        }

        if (!checkTxtRecord($business->domain, $business->getDomainVerificationKey(hash_encode($authBusinessOwner->id)))) {
            toastr()->error(d_trans('Your domain verification failed. Please note that some changes to your DNS may take time.'));
            return back();
        }

        $business->business_owner_id = $authBusinessOwner->id;
        $business->is_verified = Business::VERIFIED;
        $business->update();

        $authBusinessOwner->businesses()->attach($business->id, [
            'role' => BusinessRole::ADMIN->value,
        ]);

        Cookie::queue('current_business', $business->id, 1440 * 30);

        $title = d_trans('Business Claimed (:business_name)', ['business_name' => $business->trans->name]);
        $image = $business->getLogoLink();
        $link = route('admin.businesses.show', $business->id);
        adminNotify($title, $image, $link);

        toastr()->success(d_trans('Your business has been claimed successfully'));
        return redirect()->route('business.dashboard');
    }
}
