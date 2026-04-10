<?php

namespace App\Models;

use App\Handlers\FileHandler;
use Illuminate\Database\Eloquent\Model;

class KycVerification extends Model
{
    const STATUS_PENDING = 1;
    const STATUS_APPROVED = 2;
    const STATUS_REJECTED = 3;

    const DOCUMENT_TYPE_NATIONAL_ID = 'national_id';
    const DOCUMENT_TYPE_PASSPORT = 'passport';

    protected static function boot()
    {
        parent::boot();

        static::deleted(function ($kycVerification) {
            foreach ($kycVerification->documents as $key => $document) {
                if ($document) {
                    FileHandler::delete($document, 'private');
                }
            }
        });
    }

    public function scopePending($query)
    {
        $query->where('status', self::STATUS_PENDING);
    }

    public function isPending()
    {
        return $this->status == self::STATUS_PENDING;
    }

    public function scopeApproved($query)
    {
        $query->where('status', self::STATUS_APPROVED);
    }

    public function isApproved()
    {
        return $this->status == self::STATUS_APPROVED;
    }

    public function scopeRejected($query)
    {
        $query->where('status', self::STATUS_REJECTED);
    }

    public function isRejected()
    {
        return $this->status == self::STATUS_REJECTED;
    }

    public function isNationalIdDocument()
    {
        return $this->document_type == self::DOCUMENT_TYPE_NATIONAL_ID;
    }

    public function isPassportDocument()
    {
        return $this->document_type == self::DOCUMENT_TYPE_PASSPORT;
    }

    protected $fillable = [
        'document_type',
        'document_number',
        'documents',
        'status',
        'rejection_reason',
        'business_owner_id',
        'user_id',
    ];

    protected function casts(): array
    {
        return [
            'documents' => 'object',
            'status' => 'boolean',
        ];
    }

    public function getGuardAttribute()
    {
        return $this->user ? $this->user : $this->owner;
    }

    public function getDocumentType()
    {
        return self::getAvailableDocumentTypes()[$this->document_type];
    }

    public static function getAvailableDocumentTypes()
    {
        return [
            self::DOCUMENT_TYPE_NATIONAL_ID => d_trans('National ID'),
            self::DOCUMENT_TYPE_PASSPORT => d_trans('Passport'),
        ];
    }

    public function getStatusName()
    {
        return self::getAvailableStatuses()[$this->status];
    }

    public static function getAvailableStatuses()
    {
        return [
            self::STATUS_PENDING => d_trans('Pending'),
            self::STATUS_APPROVED => d_trans('Approved'),
            self::STATUS_REJECTED => d_trans('Rejected'),
        ];
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function owner()
    {
        return $this->belongsTo(BusinessOwner::class, 'business_owner_id');
    }
}
