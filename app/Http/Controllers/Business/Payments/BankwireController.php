<?php

namespace App\Http\Controllers\Business\Payments;

use App\Events\TransactionPending;
use App\Handlers\FileHandler;
use App\Http\Controllers\Controller;
use App\Models\Transaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class BankwireController extends Controller
{
    private $paymentGateway;

    public function __construct()
    {
        $this->paymentGateway = paymentGateway('bankwire');
    }

    public function process($trx)
    {
        try {
            $data['type'] = "success";
            $data['method'] = "hosted";
            $data['view'] = 'bankwire';
        } catch (\Exception $e) {
            $data['type'] = "error";
            $data['msg'] = $e->getMessage();
        }

        return json_encode($data);
    }

    public function submit(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'payment_proof' => ['required', 'file', 'mimes:jpg,jpeg,png,pdf'],
            'checkout_id' => ['required', 'string'],
        ]);

        if ($validator->fails()) {
            foreach ($validator->errors()->all() as $error) {
                toastr()->error($error);
            }
            return back();
        }

        try {
            $trx = Transaction::where('business_owner_id', authBusinessOwner()->id)
                ->where('id', hash_decode($request->checkout_id))
                ->unpaid()->firstOrFail();

            $paymentProof = FileHandler::upload($request->file('payment_proof'), [
                'disk' => 'private',
                'name' => $trx->id,
                'path' => "docs/transactions/",
            ]);

            if ($paymentProof) {
                $trx->payment_proof = $paymentProof;
                $trx->status = Transaction::STATUS_PENDING;
                $trx->update();

                event(new TransactionPending($trx));

                toastr()->success(d_trans('Payment proof was sent successfully. Our team will review it as soon as possible'));
                return redirect()->route('business.subscription.transactions.show', $trx->id);
            }

            return back();
        } catch (\Exception $e) {
            toastr()->error($e->getMessage());
            return back();
        }
    }
}