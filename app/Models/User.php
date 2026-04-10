<?php

namespace App\Models;

use App\Classes\AvatarGenerator;
use App\Classes\BrowserDetector;
use App\Classes\IPLookup;
use App\Classes\OSDetector;
use App\Models\UserLoginLog;
use App\Notifications\ResetPasswordNotification;
use App\Notifications\VerifyEmailNotification;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable implements MustVerifyEmail
{
    use Notifiable;

    const STATUS_BANNED = 0;
    const STATUS_ACTIVE = 1;

    const EMAIL_UNVERIFIED = 0;
    const EMAIL_VERIFIED = 1;

    const KYC_STATUS_UNVERIFIED = 0;
    const KYC_STATUS_VERIFIED = 1;

    const TWO_FACTOR_DISABLED = 0;
    const TWO_FACTOR_ACTIVE = 1;

    public function scopeActive($query)
    {
        $query->where('status', self::STATUS_ACTIVE);
    }

    public function isActive()
    {
        return $this->status == self::STATUS_ACTIVE;
    }

    public function scopeBanned($query)
    {
        $query->where('status', self::STATUS_BANNED);
    }

    public function isBanned()
    {
        return $this->status == self::STATUS_BANNED;
    }

    public function scopeEmailVerified($query)
    {
        $query->whereNotNull('email_verified_at');
    }

    public function scopeEmailUnVerified($query)
    {
        $query->whereNull('email_verified_at');
    }

    public function isEmailVerified()
    {
        return $this->email_verified_at != null;
    }

    public function scopeKycVerified($query)
    {
        $query->where('kyc_status', self::KYC_STATUS_VERIFIED);
    }

    public function hasKycVerified()
    {
        return $this->kyc_status == self::KYC_STATUS_VERIFIED;
    }

    public function scopeKycUnverified($query)
    {
        $query->where('kyc_status', self::KYC_STATUS_UNVERIFIED);
    }

    public function hasKycPending()
    {
        return !$this->hasKycVerified() && $this->kycVerifications()->pending()->exists();
    }

    public function isTwoFactorDisabled()
    {
        return $this->two_factor_status == self::TWO_FACTOR_DISABLED;
    }

    public function isTwoFactorActive()
    {
        return $this->two_factor_status == self::TWO_FACTOR_ACTIVE;
    }

    public function scopeWhereDataCompleted($query)
    {
        $query->whereNotNull('email')
            ->whereNotNull('password');
    }

    public function isDataCompleted()
    {
        if (!$this->email || !$this->password) {
            return false;
        }
        return true;
    }

    protected $fillable = [
        'firstname',
        'lastname',
        'username',
        'email',
        'country',
        'avatar',
        'password',
        'facebook_id',
        'google_id',
        'microsoft_id',
        'vkontakte_id',
        'two_factor_status',
        'two_factor_secret',
        'total_reviews',
        'kyc_status',
        'status',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
            'two_factor_status' => 'boolean',
            'total_reviews' => 'integer',
            'kyc_status' => 'integer',
            'status' => 'integer',
        ];
    }

    public function getName()
    {
        if ($this->firstname && $this->lastname) {
            return $this->firstname . ' ' . $this->lastname;
        } elseif ($this->username) {
            return $this->username;
        } elseif ($this->email) {
            $emailUsername = explode('@', $this->email);
            return $emailUsername[0];
        }
    }

    public function getCountry()
    {
        return $this->country ? countries($this->country) : d_trans('Unknown');
    }

    public function getAvatar()
    {
        if ($this->avatar) {
            return asset($this->avatar);
        }

        return AvatarGenerator::uiAvatar($this->getName());
    }

    public function getProfileLink()
    {
        return route('user.profile', strtolower($this->username));
    }

    public function getSettingsLink()
    {
        return route('user.settings.index', strtolower($this->username));
    }

    public function getKycLink()
    {
        return route('user.kyc.index', strtolower($this->username));
    }

    public function getTwoFactorSecretAttribute($value)
    {
        return decrypt($value);
    }

    public function getTwoFactorQrCode()
    {
        $qrCode = null;
        if ($this->isTwoFactorDisabled()) {
            $google2fa = app('pragmarx.google2fa');
            $secretKey = encrypt($google2fa->generateSecretKey());

            $this->two_factor_secret = $secretKey;
            $this->update();

            $qrCode = $google2fa->getQRCodeInline(
                m_trans(config('settings.general.site_name')),
                $this->email,
                $this->two_factor_secret
            );
        }

        return $qrCode;
    }

    public function pushLog()
    {
        $ip = getIp();
        $ipLookup = app(IPLookup::class)->lookup($ip);

        $loginLog = UserLoginLog::where('user_id', $this->id)->where('ip', $ip)->first();
        if (!$loginLog) {
            $loginLog = new UserLoginLog();
            $loginLog->user_id = $this->id;
            $loginLog->ip = $ipLookup->ip;
        }

        $loginLog->country = $ipLookup->country;
        $loginLog->country_code = $ipLookup->country_code;
        $loginLog->timezone = $ipLookup->timezone;
        $loginLog->location = $ipLookup->location;
        $loginLog->latitude = $ipLookup->latitude;
        $loginLog->longitude = $ipLookup->longitude;
        $loginLog->browser = BrowserDetector::get();
        $loginLog->os = OSDetector::get();
        $loginLog->save();
    }

    public function updateReviewStats()
    {
        $stats = $this->reviews()
            ->published()
            ->selectRaw('COUNT(*) as total')
            ->first();

        $this->update([
            'total_reviews' => $stats->total ?? 0,
        ]);
    }

    public function getEmailStatusName()
    {
        if ($this->isEmailVerified()) {
            return self::getAvailableEmailStatuses()[self::EMAIL_VERIFIED];
        }

        return self::getAvailableEmailStatuses()[self::EMAIL_UNVERIFIED];
    }

    public static function getAvailableEmailStatuses()
    {
        return [
            self::EMAIL_VERIFIED => d_trans('Verified'),
            self::EMAIL_UNVERIFIED => d_trans('Unverified'),
        ];
    }

    public function getKycStatusName()
    {
        return self::getAvailableKycStatuses()[$this->kyc_status];
    }

    public static function getAvailableKycStatuses()
    {
        return [
            self::KYC_STATUS_VERIFIED => d_trans('Verified'),
            self::KYC_STATUS_UNVERIFIED => d_trans('Unverified'),
        ];
    }

    public function getStatusName()
    {
        return self::getAvailableStatuses()[$this->status];
    }

    public static function getAvailableStatuses()
    {
        return [
            self::STATUS_ACTIVE => d_trans('Active'),
            self::STATUS_BANNED => d_trans('Banned'),
        ];
    }

    public function sendPasswordResetNotification($token)
    {
        $this->notify(new ResetPasswordNotification($token, 'password.reset'));
    }

    public function sendEmailVerificationNotification()
    {
        if (config('settings.user.actions.email_verification')) {
            $this->notify(new VerifyEmailNotification('verification.verify'));
        }
    }

    public function kycVerifications()
    {
        return $this->hasMany(KycVerification::class);
    }

    public function reviews()
    {
        return $this->hasMany(BusinessReview::class);
    }

    public function reports()
    {
        return $this->hasMany(BusinessReviewReport::class);
    }
}
