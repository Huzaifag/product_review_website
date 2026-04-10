<?php

namespace App\Http\Controllers\Business\Auth;

use App\BusinessRole;
use App\Http\Controllers\Controller;
use App\Models\Business;
use App\Models\Category;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\Validator;

class SetupController extends Controller
{
    protected $redirectTo;

    public function __construct()
    {
        $this->redirectTo = config('system.business.path');
    }

    public function index()
    {
        if (authBusinessOwner()->hasBusinesses()) {
            return redirect($this->redirectTo);
        }

        $categories = Category::select('id', 'name')->get();

        return theme_view('business.auth.setup', ['categories' => $categories]);
    }

    public function store(Request $request)
    {
        if (authBusinessOwner()->hasBusinesses()) {
            return redirect($this->redirectTo);
        }

        try {
            self::createBusiness($request);
            return redirect()->route('business.dashboard');

        } catch (\Exception $e) {
            toastr()->error($e->getMessage());
            return back()->withInput();
        }
    }

    public static function createBusiness($request)
    {
        $authBusinessOwner = authBusinessOwner();
        if (!$authBusinessOwner->canCreateBusiness()) {
            throw new Exception(d_trans('You cannot create more businesses'));
        }

        $validator = Validator::make($request->all(), [
            'business_name' => ['required', 'string', 'block_patterns', 'max:255'],
            'website' => ['required', 'url', 'block_patterns', 'max:255', 'unique:businesses'],
            'category' => ['required', 'integer', 'exists:categories,id'],
            'short_description' => ['required', 'string', 'block_patterns', 'min:30', 'max:60'],
        ]);

        if ($validator->fails()) {
            foreach ($validator->errors()->all() as $error) {
                throw new Exception($error);
            }
        }

        $website = cleanURL($request->website);
        $domain = cleanDomain($website);

        $businessExists = Business::where('website', $website)
            ->orWhere('domain', $domain)->exists();
        if ($businessExists) {
            throw new Exception(d_trans('The business website has already been taken'));
        }

        $business = new Business();
        $business->name = $request->business_name;
        $business->website = $website;
        $business->domain = $domain;
        $business->short_description = $request->short_description;
        $business->category_id = $request->category;
        $business->business_owner_id = $authBusinessOwner->id;
        $business->save();

        $authBusinessOwner->businesses()->attach($business->id, [
            'role' => BusinessRole::ADMIN->value,
        ]);

        Cookie::queue('current_business', $business->id, 1440 * 30);

        $title = d_trans('New Business Added (:business_name)', ['business_name' => $business->trans->name]);
        $image = $business->getLogoLink();
        $link = route('admin.businesses.show', $business->id);
        adminNotify($title, $image, $link);

        return $business;
    }
}