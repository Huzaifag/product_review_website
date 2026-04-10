<?php

namespace App\Http\Controllers\Business;

use App\Classes\Country;
use App\Classes\ImageToWebp;
use App\Handlers\FileHandler;
use App\Http\Controllers\Controller;
use App\Models\Business;
use App\Models\Category;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class SettingsController extends Controller
{
    public function index()
    {
        $categories = Category::select('id', 'name')->get();

        return theme_view('business.settings', [
            'categories' => $categories,
        ]);
    }

    public function detailsUpdate(Request $request)
    {
        $business = currentBusiness();

        $validator = Validator::make($request->all(), [
            'business_name' => ['required', 'string', 'block_patterns', 'max:255'],
            'website' => ['required', 'url', 'block_patterns', 'max:255', 'unique:businesses,website,' . $business->id],
            'category' => ['required', 'integer', 'exists:categories,id'],
            'email' => ['nullable', 'email', 'indisposable', 'block_patterns', 'max:255'],
            'phone_number' => ['nullable', 'string', 'block_patterns', 'min:10', 'max:15'],
            'short_description' => ['required', 'string', 'block_patterns', 'min:30', 'max:60'],
            'description' => ['nullable', 'string', 'block_patterns', 'max:1500'],
            'tags' => ['nullable', 'block_patterns'],
        ]);

        if ($validator->fails()) {
            foreach ($validator->errors()->all() as $error) {
                toastr()->error($error);
            }
            return back()->withInput();
        }

        $website = cleanURL($request->website);
        $domain = cleanDomain($website);

        $businessExists = Business::whereNot('id', $business->id)
            ->where(function ($query) use ($website, $domain) {
                $query->where('website', $website)
                    ->orWhere('domain', $domain);
            })->exists();

        if ($businessExists) {
            toastr()->error(d_trans('The business website has already been taken'));
            return back();
        }

        $tags = explode(',', $request->tags);
        if (count($tags) > 15) {
            toastr()->error(d_trans('Maximum 15 tags allowed'));
            return back();
        }

        $isCategoryChanged = $request->category == $business->category_id ? false : true;
        $isVerified = $business->isVerified() && $request->website == $business->website ? Business::VERIFIED : Business::UNVERIFIED;

        $business->name = $request->business_name;
        $business->website = $website;
        $business->domain = $domain;
        $business->email = $request->email;
        $business->phone = $request->phone_number;
        $business->short_description = $request->short_description;
        $business->description = $request->description;
        $business->tags = $request->tags;
        $business->is_verified = $isVerified;
        $business->category_id = $request->category;
        $business->update();

        if ($isCategoryChanged) {
            $business->subSubCategories()->detach();
        }

        toastr()->success(d_trans('Business details has been updated successfully'));
        return back()->with('accordion_id', 'accordion1');
    }

    public function logoUpdate(Request $request)
    {
        $business = currentBusiness();

        $validator = Validator::make($request->all(), [
            'logo' => ['required', 'image', 'mimes:png,jpg.jpeg', 'max:2048'],
        ]);

        $logo = $request->file('logo');

        try {
            if (!FileHandler::imageHasDimensions($logo, '512x512')) {
                throw new Exception(d_trans('The image dimensions must 512x512 pixels'));
            }

            $file = ImageToWebp::convert($logo);

            $logo = FileHandler::upload($file, [
                'path' => 'images/businesses/',
                'name' => Str::slug($business->domain) . '-' . time(),
                'old_file' => $business->logo,
            ]);

            $business->logo = $logo;
            $business->update();

            toastr()->success(d_trans('Business logo has been updated successfully'));
        } catch (Exception $e) {
            toastr()->error($e->getMessage());
        }

        return back()->with('accordion_id', 'accordion2');
    }

    public function socialLinksUpdate(Request $request)
    {
        $business = currentBusiness();

        $validator = Validator::make($request->all(), [
            'social_links.*' => ['nullable', 'string', 'block_patterns', 'max:50'],
        ]);

        if ($validator->fails()) {
            foreach ($validator->errors()->all() as $error) {
                toastr()->error($error);
            }
            return back();
        }

        $socialLinks = [];
        foreach ($request->social_links as $key => $socialLink) {
            if (!is_null($socialLink)) {
                $socialLinks[$key] = $socialLink;
            }
        }

        $business->social_links = $socialLinks;
        $business->update();

        toastr()->success(d_trans('Business social links has been updated successfully'));
        return back()->with('accordion_id', 'accordion3');
    }

    public function addressUpdate(Request $request)
    {
        $business = currentBusiness();

        $validator = Validator::make($request->all(), [
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

        $business->address_line_1 = $request->address_line_1;
        $business->address_line_2 = $request->address_line_2;
        $business->city = $request->city;
        $business->state = $request->state;
        $business->zip = $request->zip;
        $business->country = $request->country;
        $business->update();

        toastr()->success(d_trans('Business address has been updated successfully'));
        return back()->with('accordion_id', 'accordion4');
    }

    public function domainVerify(Request $request)
    {
        $business = currentBusiness();

        abort_if($business->isVerified(), 403);

        if (!checkTxtRecord($business->domain, $business->getDomainVerificationKey())) {
            toastr()->error(d_trans('Your domain verification failed. Please note that some changes to your DNS may take time.'));
            return back();
        }

        $business->is_verified = Business::VERIFIED;
        $business->update();

        toastr()->success(d_trans('Your business domain has been verified successfully'));
        return back()->with('accordion_id', 'accordion5');
    }

    public function businessDelete(Request $request)
    {
        abort_if(!authBusinessOwner()->isSuperAdminOfCurrentBusiness(), 403);

        $business = currentBusiness();
        $business->delete();

        toastr()->success(d_trans('You business ":business_name" has been deleted successfully', [
            'business_name' => $business->trans->name,
        ]));
        return back();
    }
}
