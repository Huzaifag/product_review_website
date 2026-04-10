<?php

namespace App\Models;

use App\Handlers\FileHandler;
use App\Models\Tax;
use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    const STATUS_UNPAID = 0;
    const STATUS_PENDING = 1;
    const STATUS_PAID = 2;
    const STATUS_CANCELLED = 3;

    protected static function boot()
    {
        parent::boot();

        static::deleted(function ($transaction) {
            if ($transaction->payment_proof) {
                FileHandler::delete($transaction->payment_proof, 'private');
            }
        });
    }

    public function scopeUnpaid($query)
    {
        return $query->where('status', self::STATUS_UNPAID);
    }

    public function isUnpaid()
    {
        return $this->status == self::STATUS_UNPAID;
    }

    public function scopePending($query)
    {
        return $query->where('status', self::STATUS_PENDING);
    }

    public function isPending()
    {
        return $this->status == self::STATUS_PENDING;
    }

    public function scopePaid($query)
    {
        return $query->where('status', self::STATUS_PAID);
    }

    public function isPaid()
    {
        return $this->status == self::STATUS_PAID;
    }

    public function scopeCancelled($query)
    {
        return $query->where('status', self::STATUS_CANCELLED);
    }

    public function isCancelled()
    {
        return $this->status == self::STATUS_CANCELLED;
    }

    public function hasFees()
    {
        return $this->fees > 0;
    }

    public function hasTax()
    {
        return $this->tax != null;
    }

    protected $fillable = [
        'amount',
        'fees',
        'tax',
        'total',
        'payment_id',
        'payer_id',
        'payer_email',
        'payment_proof',
        'status',
        'business_owner_id',
        'plan_id',
        'payment_gateway_id',
        'cancellation_reason',
    ];

    protected function casts(): array
    {
        return [
            'amount' => 'double',
            'fees' => 'double',
            'tax' => 'object',
            'total' => 'double',
            'status' => 'integer',
        ];
    }

    public function getStatusName()
    {
        return self::getAvailableStatues()[$this->status];
    }

    public static function getAvailableStatues()
    {
        return [
            self::STATUS_PENDING => d_trans('Pending'),
            self::STATUS_PAID => d_trans('Paid'),
            self::STATUS_CANCELLED => d_trans('Cancelled'),
        ];
    }

    public function calculate()
    {
        $total = $this->amount;

        $tax = null;

        $businessOwner = $this->owner;

        $tax = Tax::whereJsonContains('countries', @$businessOwner->address->country)->first();

        if ($tax) {
            $taxRate = $tax->rate;
            $taxAmount = round((($total * $taxRate) / 100), 2);

            $tax = [
                'name' => $tax->name,
                'rate' => $taxRate,
                'amount' => $taxAmount,
            ];

            $total += $taxAmount;
        }

        $paymentGateway = $this->paymentGateway;

        $fees = 0;
        if ($paymentGateway->fees > 0) {
            $fees = ($total * $paymentGateway->fees) / 100;
        }

        $total += round($fees, 2);

        $this->tax = $tax;
        $this->fees = $fees;
        $this->total = $total;
        $this->update();
    }

    public function owner()
    {
        return $this->belongsTo(BusinessOwner::class, 'business_owner_id');
    }

    public function plan()
    {
        return $this->belongsTo(Plan::class);
    }

    public function paymentGateway()
    {
        return $this->belongsTo(PaymentGateway::class);
    }

}
