<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Jobs\SendKycApprovedNotification;
use App\Jobs\SendKycRejectedNotification;
use App\Models\BusinessOwner;
use App\Models\KycVerification;
use App\Models\User;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class KycVerificationController extends Controller
{
    public function index()
    {
        $documentTypes = KycVerification::getAvailableDocumentTypes();
        $statuses = KycVerification::getAvailableStatuses();

        $kycVerifications = KycVerification::query();

        if (request()->filled('search')) {
            $searchTerm = '%' . request('search') . '%';
            $kycVerifications->where(function ($query) use ($searchTerm) {
                $query->where('id', 'like', $searchTerm)
                    ->orWhere('user_id', 'like', $searchTerm)
                    ->orWhere('business_owner_id', 'like', $searchTerm)
                    ->orWhere('document_type', 'like', $searchTerm)
                    ->orWhere('document_number', 'like', $searchTerm)
                    ->OrWhereHas('user', function ($query) use ($searchTerm) {
                        $query->where('firstname', 'like', $searchTerm)
                            ->orWhere('lastname', 'like', $searchTerm)
                            ->orWhere('username', 'like', $searchTerm)
                            ->orWhere('email', 'like', $searchTerm)
                            ->orWhere('facebook_id', 'like', $searchTerm)
                            ->orWhere('google_id', 'like', $searchTerm)
                            ->orWhere('microsoft_id', 'like', $searchTerm)
                            ->orWhere('vkontakte_id', 'like', $searchTerm);
                    })
                    ->OrWhereHas('owner', function ($query) use ($searchTerm) {
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
            });
        }

        if (request()->filled('user')) {
            $kycVerifications->where('user_id', request('user'));
        } elseif (request()->filled('owner')) {
            $kycVerifications->where('business_owner_id', request('owner'));
        }

        if (request()->filled('status')) {
            $kycVerifications->where('status', request('status'));
        }

        if (request()->filled('document_type')) {
            $kycVerifications->where('document_type', request('document_type'));
        }

        $filteredKycVerifications = $kycVerifications->get();

        $counters['pending'] = $filteredKycVerifications->where('status', KycVerification::STATUS_PENDING)->count();
        $counters['approved'] = $filteredKycVerifications->where('status', KycVerification::STATUS_APPROVED)->count();
        $counters['rejected'] = $filteredKycVerifications->where('status', KycVerification::STATUS_REJECTED)->count();

        $kycVerifications = $kycVerifications->orderbyDesc('id')->paginate(50);
        $kycVerifications->appends(request()->only(['search', 'user', 'owner', 'status', 'document_type']));

        return view('admin.kyc-verifications.index', [
            'counters' => $counters,
            'documentTypes' => $documentTypes,
            'statuses' => $statuses,
            'kycVerifications' => $kycVerifications,
        ]);
    }

    public function show(KycVerification $kycVerification)
    {
        return view('admin.kyc-verifications.show', [
            'kycVerification' => $kycVerification,
        ]);
    }

    public function approve(Request $request, KycVerification $kycVerification)
    {
        abort_if(!$kycVerification->isPending(), 403);

        $kycVerification->status = KycVerification::STATUS_APPROVED;
        $kycVerification->update();

        dispatch(new SendKycApprovedNotification($kycVerification));

        $guard = $kycVerification->guard;
        $guard->kyc_status = $kycVerification->user ? User::KYC_STATUS_VERIFIED : BusinessOwner::KYC_STATUS_VERIFIED;
        $guard->update();

        toastr()->success(d_trans('KYC Verification has been Approved'));
        return back();
    }

    public function reject(Request $request, KycVerification $kycVerification)
    {
        abort_if(!$kycVerification->isPending(), 403);

        $validator = Validator::make($request->all(), [
            'rejection_reason' => ['required', 'string'],
        ]);

        if ($validator->fails()) {
            foreach ($validator->errors()->all() as $error) {
                toastr()->error($error);
            }
            return back();
        }

        $kycVerification->status = KycVerification::STATUS_REJECTED;
        $kycVerification->rejection_reason = $request->rejection_reason;
        $kycVerification->update();

        if ($request->has('email_notification')) {
            dispatch(new SendKycRejectedNotification($kycVerification));
        }

        toastr()->success(d_trans('KYC Verification has been Rejected'));
        return back();
    }

    public function document(KycVerification $kycVerification, $document)
    {
        try {
            $document = $kycVerification->documents->$document;
            abort_if(!$document, 404);
            $file = Storage::disk('private')->get($document);
            $response = \Response::make($file, 200);
            $response->header("Content-Type", Storage::mimeType($document));
            return $response;
        } catch (Exception $e) {
            return abort(404);
        }
    }

    public function download(KycVerification $kycVerification, $document)
    {
        try {
            $document = $kycVerification->documents->$document;
            abort_if(!$document, 404);
            return Storage::disk('private')->download($document);
        } catch (Exception $e) {
            toastr()->error($e->getMessage());
            return back();
        }
    }

    public function destroy(KycVerification $kycVerification)
    {
        $kycVerification->delete();

        toastr()->success(d_trans('Deleted Successfully'));
        return back();
    }
}
