<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\PaymentGateway;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class PaymentGatewayController extends Controller
{
    public function index()
    {
        $paymentGateways = PaymentGateway::query();

        if (request()->filled('search')) {
            $searchTerm = '%' . request('search') . '%';
            $paymentGateways->where('name', 'like', $searchTerm)
                ->orWhere('alias', 'like', $searchTerm);
        }

        $paymentGateways = $paymentGateways->get();

        return view('admin.payment-methods.index', [
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
            $method = PaymentGateway::find($id);
            $method->sort_id = ($sortOrder + 1);
            $method->update();
        }

        return response()->json(['success' => true]);
    }

    public function create()
    {
        $paymentTypes = [
            'stripe' => d_trans('Stripe'),
            'paypal' => d_trans('PayPal'),
            'razorpay' => d_trans('Razorpay'),
        ];
        return view('admin.payment-methods.create', compact('paymentTypes'));
    }

    public function store(Request $request)
    {
        if ($request->is_active == 'on') {
            $request->merge(['is_active' => true]);
        } else {
            $request->merge(['is_active' => false]);
        }
        $validator = Validator::make($request->all(), [
            'name' => ['required', 'string', 'max:255'],
            'type' => ['required', 'string', 'max:255', 'unique:payment_gateways,alias'],
            'environment' => ['required', 'string', 'in:sandbox,live'],
            'is_active' => ['nullable', 'boolean'],
            'description' => ['nullable', 'string'],
            'credentials' => ['nullable', 'array'],
            'credentials.*.key' => ['nullable', 'string', 'max:255'],
            'credentials.*.value' => ['nullable', 'string'],
        ]);

        if ($validator->fails()) {
            foreach ($validator->errors()->all() as $error) {
                toastr()->error($error);
            }
            return back()->withInput();
        }

        $alias = $request->type;
        $credentials = $this->normalizeCredentials($request->input('credentials', []));
        $logo = $this->resolveGatewayLogo($alias);

        $paymentGateway = new PaymentGateway();
        $paymentGateway->name = $request->name;
        $paymentGateway->alias = $alias;
        $paymentGateway->logo = $logo;
        $paymentGateway->fees = 0;
        $paymentGateway->currency = null;
        $paymentGateway->rate = null;
        $paymentGateway->credentials = $credentials ?: null;
        $paymentGateway->instructions = $request->description;
        $paymentGateway->mode = $request->environment;
        $paymentGateway->status = $request->has('is_active') ? PaymentGateway::STATUS_ACTIVE : PaymentGateway::STATUS_DISABLED;
        $paymentGateway->type = PaymentGateway::TYPE_AUTO;
        $paymentGateway->save();

        toastr()->success(d_trans('Created Successfully'));
        return redirect()->route('admin.payment-methods.edit', $paymentGateway->id);
    }

    public function edit($id)
    {

        $paymentTypes = [
            'stripe' => d_trans('Stripe'),
            'paypal' => d_trans('PayPal'),
            'razorpay' => d_trans('Razorpay'),
        ];

        $paymentGateway = PaymentGateway::findOrFail($id);

        return view('admin.payment-methods.edit', [
            'paymentGateway' => $paymentGateway,
            'paymentTypes' => $paymentTypes,
        ]);
    }

    public function update(Request $request, PaymentGateway $payment_method)
    {
        if ($request->is_active == 'on') {
            $request->merge(['is_active' => true]);
        } else {
            $request->merge(['is_active' => false]);
        }
        $validator = Validator::make($request->all(), [
            'name' => ['required', 'string', 'max:255'],
            'type' => ['required', 'string', 'max:255', Rule::unique('payment_gateways', 'alias')->ignore($payment_method->id)],
            'environment' => ['required', 'string', 'in:sandbox,live'],
            'is_active' => ['nullable', 'boolean'],
            'description' => ['nullable', 'string'],
            'credentials' => ['nullable', 'array'],
            'credentials.*.key' => ['nullable', 'string', 'max:255'],
            'credentials.*.value' => ['nullable', 'string'],
        ]);

        if ($validator->fails()) {
            foreach ($validator->errors()->all() as $error) {
                toastr()->error($error);
            }
            return back()->withInput();
        }

        $alias = $request->type;
        $credentials = $this->normalizeCredentials($request->input('credentials', []));
        $logo = $this->resolveGatewayLogo($alias, $payment_method->logo);

        $payment_method->name = $request->name;
        $payment_method->alias = $alias;
        $payment_method->logo = $logo;
        $payment_method->credentials = $credentials ?: $payment_method->credentials;
        $payment_method->instructions = $request->description;
        $payment_method->mode = $request->environment;
        $payment_method->status = $request->has('is_active') ? PaymentGateway::STATUS_ACTIVE : PaymentGateway::STATUS_DISABLED;
        $payment_method->type = PaymentGateway::TYPE_AUTO;
        $payment_method->update();

        toastr()->success(d_trans('Updated Successfully'));
        return back();
    }

    public function destroy(PaymentGateway $payment_method)
    {
        $payment_method->delete();
        toastr()->success(d_trans('Deleted Successfully'));
        return back();
    }

    private function normalizeCredentials(array $rows): array
    {
        $credentials = [];

        foreach ($rows as $row) {
            $key = isset($row['key']) ? trim($row['key']) : '';
            $value = isset($row['value']) ? $row['value'] : null;
            if ($key !== '') {
                $credentials[$key] = $value;
            }
        }

        return $credentials;
    }

    private function resolveGatewayLogo(string $alias, ?string $current = null): string
    {
        $relativePath = 'images/payment-gateways/' . $alias . '.png';
        $fullPath = public_path($relativePath);

        if (file_exists($fullPath)) {
            return $relativePath;
        }

        return $current ?: $relativePath;
    }
}
