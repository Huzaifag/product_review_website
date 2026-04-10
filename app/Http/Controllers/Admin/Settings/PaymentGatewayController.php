<?php

namespace App\Http\Controllers\Admin\Settings;

use App\Handlers\FileHandler;
use App\Http\Controllers\Controller;
use App\Models\PaymentGateway;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class PaymentGatewayController extends Controller
{
    public function index()
    {
        $paymentGateways = PaymentGateway::query();

        if (request()->filled('search')) {
            $searchTerm = '%' . request('search') . '%';
            $paymentGateways->where(function ($query) use ($searchTerm) {
                $query->where('name', 'like', $searchTerm)
                    ->orWhere('alias', 'like', $searchTerm)
                    ->orWhere('credentials', 'like', $searchTerm);
            });
        }

        if (request()->filled('status')) {
            $paymentGateways->where('status', request('status'));
        }

        $paymentGateways = $paymentGateways->get();

        return view('admin.settings.payment-gateways.index', [
            'paymentGateways' => $paymentGateways,
        ]);
    }

    public function sortable(Request $request)
    {
        $ids = $request->ids;

        if (!$ids || is_null($ids) || !is_array($ids)) {
            return response()->json(['error' => d_trans('Failed to sort the table')]);
        }

        foreach ($ids as $sortOrder => $id) {
            $paymentGateway = PaymentGateway::find($id);
            $paymentGateway->sort_id = ($sortOrder + 1);
            $paymentGateway->update();
        }

        return response()->json(['success' => true]);
    }

    public function edit(PaymentGateway $paymentGateway)
    {
        return view('admin.settings.payment-gateways.edit', [
            'paymentGateway' => $paymentGateway,
        ]);
    }

    public function update(Request $request, PaymentGateway $paymentGateway)
    {
        $validator = Validator::make($request->all(), [
            'logo' => ['nullable', 'mimes:png,jpg,jpeg'],
            'name' => ['required', 'string', 'block_patterns', 'max:255'],
            'fees' => ['required', 'integer', 'min:0', 'max:100'],
            'currency' => ['nullable', 'string', 'max:10', 'required_with:rate'],
            'rate' => ['nullable', 'numeric', 'min:0.000000001', 'required_with:currency'],
        ]);

        if ($validator->fails()) {
            foreach ($validator->errors()->all() as $error) {
                toastr()->error($error);
            }
            return back();
        }

        if ($paymentGateway->mode) {
            if (!in_array($request->mode, PaymentGateway::getAvailableModes())) {
                toastr()->error(d_trans('Invalid mode'));
                return back();
            }
        } else {
            $request->mode = null;
        }

        if (!$paymentGateway->isManual()) {
            if ($request->currency == config('settings.currency.code')) {
                toastr()->error(d_trans('Currency should be different from website currency or leave it empty'));
                return back();
            }

            $request->instructions = null;
            foreach ($request->credentials as $key => $value) {
                if (!array_key_exists($key, (array) $paymentGateway->credentials)) {
                    toastr()->error(d_trans('Credentials error'));
                    return back();
                }
                if ($request->has('status')) {
                    if (empty($value)) {
                        toastr()->error(d_trans(':key cannot be empty', ['key' => d_trans(str_replace('_', ' ', ucfirst($key)))]));
                        return back();
                    }
                }
            }
        } else {
            if ($request->has('status')) {
                if (empty($request->instructions)) {
                    toastr()->error(d_trans('Instructions cannot be empty'));
                    return back();
                }
            }
            $request->credentials = null;
            $request->currency = null;
            $request->rate = null;
        }

        try {
            if ($request->has('logo')) {
                $logo = FileHandler::upload($request->file('logo'), [
                    'name' => $paymentGateway->alias,
                    'path' => 'images/payment-gateways/',
                    'old_file' => $paymentGateway->logo,
                ]);
            } else {
                $logo = $paymentGateway->logo;
            }
        } catch (Exception $e) {
            toastr()->error($e->getMessage());
            return back();
        }

        $request->status = $request->has('status') ? PaymentGateway::STATUS_ACTIVE : PaymentGateway::STATUS_DISABLED;

        $paymentGateway->name = $request->name;
        $paymentGateway->logo = $logo;
        $paymentGateway->fees = $request->fees;
        $paymentGateway->currency = $request->currency;
        $paymentGateway->rate = $request->rate;
        $paymentGateway->credentials = $request->credentials;
        $paymentGateway->instructions = $request->instructions;
        $paymentGateway->mode = $request->mode;
        $paymentGateway->status = $request->status;
        $paymentGateway->update();

        toastr()->success(d_trans('Updated Successfully'));
        return back();
    }
}