<?php

namespace App\Http\Controllers\Admin;

use App\BusinessRole;
use App\Classes\Country;
use App\Classes\ImageToWebp;
use App\Classes\SendMail;
use App\Handlers\FileHandler;
use App\Http\Controllers\Controller;
use App\Imports\BusinessesImport;
use App\Models\Business;
use App\Models\BusinessEmployee;
use App\Models\BusinessReview;
use App\Models\Category;
use App\Models\SubCategory;
use App\Traits\Charts;
use Carbon\Carbon;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Maatwebsite\Excel\Facades\Excel;
use Maatwebsite\Excel\Validators\ValidationException;

class BusinessController extends Controller
{
    use Charts;

    public function index()
    {
        $businesses = Business::query();

        if (request()->filled('search')) {
            $searchTerm = '%' . request('search') . '%';
            $searchTermStart = request('search') . '%';
            $businesses->search($searchTerm, $searchTermStart);
        }

        if (request()->filled('owner')) {
            $businesses->where('business_owner_id', request('owner'));
        }

        if (request()->filled('employee')) {
            $businesses->whereHas('employees', function ($query) {
                $query->where('business_owners.id', request('employee'));
            });
        }

        if (request()->filled('category')) {
            $businesses->where('category_id', request('category'));
        }

        if (request()->filled('sub_category')) {
            $businesses->orWhereHas('subSubCategories.subCategory', function ($query) {
                $query->where('sub_categories.id', request('sub_category'));
            });
        }

        if (request()->filled('sub_sub_category')) {
            $businesses->orWhereHas('subSubCategories', function ($query) {
                $query->where('sub_sub_categories.id', request('sub_sub_category'));
            });
        }

        if (request()->filled('verification')) {
            $businesses->where('is_verified', request('verification'));
        }

        if (request()->filled('status')) {
            $businesses->where('status', request('status'));
        }

        $filteredBusinesses = $businesses->get();
        $counters['active'] = $filteredBusinesses->where('status', Business::STATUS_ACTIVE)->count();
        $counters['suspended'] = $filteredBusinesses->where('status', Business::STATUS_SUSPENDED)->count();
        $counters['verified'] = $filteredBusinesses->where('status', Business::VERIFIED)->count();
        $counters['unverified'] = $filteredBusinesses->where('status', Business::UNVERIFIED)->count();

        $businesses = $businesses->with('owner')->orderbyDesc('id')->paginate(50);
        $businesses->appends(request()->only(['search', 'verification', 'status']));

        return view('admin.businesses.index', [
            'counters' => $counters,
            'businesses' => $businesses,
        ]);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'business_name' => ['required', 'string', 'block_patterns', 'max:255'],
            'website' => ['required', 'url', 'block_patterns', 'max:255', 'unique:businesses'],
        ]);

        if ($validator->fails()) {
            foreach ($validator->errors()->all() as $error) {
                toastr()->error($error);
            }
            return back()->withInput();
        }

        $website = cleanURL($request->website);
        $domain = cleanDomain($website);

        $businessExists = Business::where('website', $website)
            ->orWhere('domain', $domain)->exists();
        if ($businessExists) {
            toastr()->error(d_trans('The business website has already been taken'));
            return back();
        }

        $websiteName = config('settings.general.site_name');
        $shortDescription = "Rate and review {$request->business_name} on {$websiteName}";

        $business = new Business();
        $business->name = $request->business_name;
        $business->website = $website;
        $business->domain = $domain;
        $business->short_description = $shortDescription;
        $business->save();

        toastr()->success(d_trans('Added successfully'));
        return redirect()->route('admin.businesses.show', $business->id);
    }

    public function bulkUpload(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'businesses_file' => ['required', 'mimetypes:text/plain,text/csv,text/tsv,text/comma-separated-values,application/csv,application/excel,application/vnd.ms-excel'],
        ]);

        if ($validator->fails()) {
            foreach ($validator->errors()->all() as $error) {
                toastr()->error($error);
            }
            return back()->withInput();
        }

        try {
            Excel::import(new BusinessesImport, $request->file('businesses_file'));

            toastr()->success(d_trans('Imported successfully'));
        } catch (ValidationException $e) {
            foreach ($e->failures() as $failure) {
                toastr()->error(d_trans('Row :row : :errors', ['row' => $failure->row(), 'errors' => implode(', ', $failure->errors())]));
            }
        } catch (\Exception $e) {
            toastr()->error($e->getMessage());
        }

        return back();
    }

    public function downloadCSV()
    {
        return response()->download(storage_path('app/example/businesses-bulk-upload.csv'));
    }

    public function show(Business $business)
    {
        $categories = Category::select('id', 'name')->get();

        return view('admin.businesses.show', [
            'categories' => $categories,
            'business' => $business,
        ]);
    }

    public function detailsUpdate(Request $request, Business $business)
    {
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

    public function logoUpdate(Request $request, Business $business)
    {
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

    public function socialLinksUpdate(Request $request, Business $business)
    {
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

    public function addressUpdate(Request $request, Business $business)
    {
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

    public function categories(Business $business)
    {
        $businessSubSubCategoryIds = $business->subSubCategories()->pluck('sub_sub_categories.id');

        $searchTerm = request()->get('search', '');

        $subCategories = SubCategory::where('category_id', $business->category_id)
            ->whereIn('id', function ($query) use ($businessSubSubCategoryIds) {
                $query->select('sub_category_id')
                    ->from('sub_sub_categories')
                    ->whereIn('id', $businessSubSubCategoryIds);
            })
            ->where(function ($query) use ($searchTerm, $businessSubSubCategoryIds) {
                $query->where('name', 'like', '%' . $searchTerm . '%')
                    ->orWhere('slug', 'like', '%' . $searchTerm . '%')
                    ->orWhere('title', 'like', '%' . $searchTerm . '%')
                    ->orWhere('description', 'like', '%' . $searchTerm . '%')
                    ->orWhere('keywords', 'like', '%' . $searchTerm . '%')
                    ->orWhereHas('subSubCategories', function ($q) use ($searchTerm, $businessSubSubCategoryIds) {
                        $q->whereIn('id', $businessSubSubCategoryIds)
                            ->where(function ($q2) use ($searchTerm) {
                                $q2->where('name', 'like', '%' . $searchTerm . '%')
                                    ->orWhere('slug', 'like', '%' . $searchTerm . '%')
                                    ->orWhere('title', 'like', '%' . $searchTerm . '%')
                                    ->orWhere('description', 'like', '%' . $searchTerm . '%')
                                    ->orWhere('keywords', 'like', '%' . $searchTerm . '%');
                            });
                    });
            })
            ->paginate(20);

        $subCategories->appends(request()->only(['search']));

        $tableCategories = $subCategories->map(function ($subCategory) use ($businessSubSubCategoryIds) {
            $subSubCategories = $subCategory->subSubCategories()
                ->whereIn('id', $businessSubSubCategoryIds)
                ->get();

            return [
                'subCategory' => [
                    'id' => $subCategory->id,
                    'name' => $subCategory->trans->name,
                    'slug' => $subCategory->slug,
                ],
                'subSubCategories' => $subSubCategories->pluck('name')->toArray(),
            ];
        });

        return view('admin.businesses.categories', [
            'business' => $business,
            'subCategories' => $subCategories,
            'tableCategories' => $tableCategories,
        ]);
    }

    public function categoriesDelete(Business $business, SubCategory $subCategory)
    {
        abort_if($business->category->id != $subCategory->category->id, 403);

        $subSubIds = $subCategory->subSubCategories->pluck('id');
        $business->subSubCategories()->detach($subSubIds);

        toastr()->success(d_trans('Deleted successfully.'));
        return back();
    }

    public function employees(Business $business)
    {
        $roles = BusinessRole::cases();
        $statuses = BusinessEmployee::getAvailableStatuses();

        $employees = BusinessEmployee::where('business_id', $business->id);

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

        return view('admin.businesses.employees', [
            'business' => $business,
            'roles' => $roles,
            'statuses' => $statuses,
            'employees' => $employees,
        ]);
    }

    public function employeesDelete(Business $business, BusinessEmployee $businessEmployee)
    {
        abort_if($business->id != $businessEmployee->business->id, 403);

        if ($businessEmployee->owner) {
            $businessEmployee->owner->businesses()->detach($business->id);
        }

        $businessEmployee->delete();

        toastr()->success(d_trans('Deleted successfully'));
        return back();
    }

    public function reviews(Business $business)
    {
        $reviews = $business->reviews()
            ->published()->with(['user', 'reply']);

        if (request()->filled('status')) {
            if (request('status') == "replied") {
                $reviews->whereHas('reply');
            } elseif (request('status') == "not_replied") {
                $reviews->whereDoesntHave('reply');
            }
        }

        if (request()->filled('search')) {
            $searchTerm = '%' . request('search') . '%';
            $searchTermStart = request('search') . '%';
            $reviews->search($searchTerm, $searchTermStart);
        }

        if (request()->filled('date_from')) {
            $dateFrom = Carbon::parse(request('date_from'))->startOfDay();
            $reviews->where('created_at', '>=', $dateFrom);
        }

        if (request()->filled('date_to')) {
            $dateTo = Carbon::parse(request('date_to'))->endOfDay();
            $reviews->where('created_at', '<=', $dateTo);
        }

        if (request()->filled('stars')) {
            $reviews->whereIn('stars', request('stars'));
        }

        if (request()->filled('sort')) {
            if (request('sort') === 'recent') {
                $reviews->orderBy('created_at', 'desc');
            } elseif (request('sort') === 'oldest') {
                $reviews->orderBy('created_at', 'asc');
            } else {
                $reviews->orderbyDesc('id');
            }
        } else {
            $reviews->orderbyDesc('id');
        }

        $reviews = $reviews->paginate(20);
        $reviews->appends(request()->only(['search', 'status', 'date_from', 'date_to', 'stars', 'sort']));

        return view('admin.businesses.reviews', [
            'business' => $business,
            'reviews' => $reviews,
        ]);
    }

    public function reviewsDelete(Business $business, BusinessReview $businessReview)
    {
        abort_if($business->id != $businessReview->business->id, 403);

        $businessReview->delete();

        toastr()->success(d_trans('Deleted Successfully'));
        return back();
    }

    public function reviewsReplyDelete(Business $business, BusinessReview $businessReview)
    {
        abort_if($business->id != $businessReview->business->id, 403);

        if ($businessReview->hasReply()) {
            $businessReview->reply->delete();
        }

        toastr()->success(d_trans('Deleted Successfully'));
        return back();
    }

    public function statistics(Business $business)
    {
        $startDate = Carbon::now()->startOfMonth();
        $endDate = Carbon::now()->endOfMonth();

        $reviewsChart = $this->reviewsChart($startDate, $endDate, $business);
        $viewsChart = $this->viewsChart($startDate, $endDate, $business);

        if (request()->filled('reviews_date')) {
            $period = request()->input('reviews_date');
            $startDate = Carbon::parse($period)->startOfMonth();
            $endDate = Carbon::parse($period)->endOfMonth();

            $reviewsChart = $this->reviewsChart($startDate, $endDate, $business);
        }

        if (request()->filled('views_date')) {
            $period = request()->input('views_date');
            $startDate = Carbon::parse($period)->startOfMonth();
            $endDate = Carbon::parse($period)->endOfMonth();

            $viewsChart = $this->viewsChart($startDate, $endDate, $business);
        }

        $charts['reviews'] = $reviewsChart;
        $charts['views'] = $viewsChart;

        return view('admin.businesses.statistics', [
            'business' => $business,
            'charts' => $charts,
        ]);
    }

    public function makeFeatured(Business $business)
    {
        $business->is_featured = Business::FEATURED;
        $business->update();

        toastr()->success(d_trans('The business marked as featured successfully'));
        return back();
    }

    public function removeFeatured(Business $business)
    {
        $business->is_featured = Business::NOT_FEATURED;
        $business->update();

        toastr()->success(d_trans('The business marked as not featured successfully'));
        return back();
    }

    public function activate(Business $business)
    {
        $business->status = Business::STATUS_ACTIVE;
        $business->update();

        $owner = $business->owner;
        if ($owner) {
            SendMail::send($owner->email, 'business_activated', [
                'name' => $owner->getName(),
                'business_name' => $business->trans->name,
                'business_link' => $business->getLink(),
                'website_name' => m_trans(config('settings.general.site_name')),
            ]);
        }

        toastr()->success(d_trans('The business has been activated'));
        return back();
    }

    public function suspend(Business $business)
    {
        $business->status = Business::STATUS_SUSPENDED;
        $business->update();

        $owner = $business->owner;
        if ($owner) {
            SendMail::send($owner->email, 'business_suspended', [
                'name' => $owner->getName(),
                'business_name' => $business->trans->name,
                'website_name' => m_trans(config('settings.general.site_name')),
            ]);
        }

        toastr()->success(d_trans('The business has been suspended'));
        return back();
    }

    public function destroy(Business $business)
    {
        $business->delete();

        toastr()->success(d_trans('Deleted Successfully'));
        return back();
    }
}
