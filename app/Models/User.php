<?php

namespace App\Models;

use App\Classes\AvatarGenerator;
use App\Classes\BrowserDetector;
use App\Classes\IPLookup;
use App\Classes\OSDetector;
use App\Notifications\ResetPasswordNotification;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Log;
use Mail;
use Illuminate\Support\Facades\URL;

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
            $loginLog = new UserLoginLog;
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
            $this->emailVerification();
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

    public function productReviews()
    {
        return $this->hasMany(UserReview::class);
    }

    public function savedProducts()
    {
        return $this->hasMany(SavedProduct::class);
    }

    public function userProductViewCounts()
    {
        return $this->hasMany(UserProductViewCount::class);
    }

    // Plan and Subscription related methods
    public function subscriptions()
    {
        return $this->hasMany(Subscription::class);
    }

    public function currentPlans()
    {
        $subscriptions = $this->subscriptions()->active()->latest()->get();

        return $subscriptions->isNotEmpty() ? $subscriptions->pluck('plan') : null;
    }

    public function emailVerification()
    {
        Log::info('emailVerification method called for user ID: ' . $this->id . ' Email: ' . $this->email);

        if (!config('settings.smtp.status')) {
            Log::warning('SMTP is disabled (config settings.smtp.status is false). Cannot send email verification notification.');

            return;
        }

        try {
            Log::info('SMTP is enabled. Proceeding to generate verification URL.');
            $user = $this;

            $verificationUrl = URL::temporarySignedRoute(
                'custom.verification.verified',
                now()->addMinutes(60),
                [
                    'id' => $user->id,
                    'hash' => sha1($user->getEmailForVerification()),
                ]
            );

            Log::info('Verification URL generated successfully: ' . $verificationUrl);

            $email = $user->email;
            $subject = 'Please verify your email address';


            $userName = e($user->getName());
            $currentYear = date('Y');

            $msg = <<<HTML
            <div style="margin:0; padding:0; background:#f6f3f1; font-family:Arial, Helvetica, sans-serif;">
                <div style="max-width:640px; margin:0 auto; padding:40px 20px;">

                    <div style="text-align:center; margin-bottom:24px;">
                        <div style="display:inline-block; background:#c62828; color:#ffffff; font-size:20px; font-weight:800; letter-spacing:1px; padding:10px 18px; border-radius:10px;">
                            OKO Test
                        </div>
                    </div>

                    <div style="background:#ffffff; border-radius:18px; overflow:hidden; border:1px solid #eee2df; box-shadow:0 18px 45px rgba(33, 20, 20, 0.08);">
                        
                        <div style="background:linear-gradient(135deg, #c62828 0%, #e45858 100%); padding:34px 30px; text-align:center;">
                            <h1 style="margin:0; color:#ffffff; font-size:28px; line-height:1.3; font-weight:800;">
                                Verify Your Email
                            </h1>
                            <p style="margin:10px 0 0; color:#ffecec; font-size:15px; line-height:1.6;">
                                One quick step to activate your OKO Test account.
                            </p>
                        </div>

                        <div style="padding:36px 34px 30px;">
                            <p style="margin:0 0 18px; color:#2b2b2b; font-size:16px; line-height:1.7;">
                                Dear <strong>{$userName}</strong>,
                            </p>

                            <p style="margin:0 0 20px; color:#555555; font-size:15px; line-height:1.8;">
                                Thank you for registering with <strong style="color:#c62828;">OKO Test</strong>. 
                                Please confirm your email address to complete your registration and secure your account.
                            </p>

                            <div style="text-align:center; margin:34px 0;">
                                <a href="{$verificationUrl}"
                                style="display:inline-block; background:#c62828; color:#ffffff; padding:15px 34px; 
                                        text-decoration:none; border-radius:999px; font-size:15px; font-weight:700;
                                        box-shadow:0 10px 22px rgba(198, 40, 40, 0.28);">
                                    Verify Email Address
                                </a>
                            </div>

                            <div style="background:#fff7f6; border:1px solid #f4d4d0; border-radius:12px; padding:16px 18px; margin-bottom:24px;">
                                <p style="margin:0; color:#7a3b36; font-size:14px; line-height:1.7;">
                                    For your security, this verification link will expire in 60 minutes. If you did not create an account with OKO Test, you can safely ignore this email.
                                </p>
                            </div>
                        </div>

                        <div style="background:#faf7f6; border-top:1px solid #eee2df; padding:22px 34px; text-align:center;">
                            <p style="margin:0; color:#777777; font-size:13px; line-height:1.6;">
                                Best regards,<br>
                                <strong style="color:#222222;">OKO Test Team</strong>
                            </p>
                        </div>
                    </div>

                    <p style="text-align:center; margin:22px 0 0; color:#999999; font-size:12px; line-height:1.6;">
                        © {$currentYear} OKO Test. All rights reserved.
                    </p>

                </div>
            </div>
            HTML;

            Log::info('Attempting to send email via Mail::send() to: ' . $email);

            Mail::send([], [], function ($message) use ($msg, $email, $subject) {
                $message->to($email)
                    ->subject($subject)
                    ->html($msg);
            });

            Log::info('Mail::send() executed successfully without throwing exceptions for user: ' . $email);

        } catch (\Exception $e) {
            Log::error('Failed to send email verification notification: ' . $e->getMessage());
            Log::error($e->getTraceAsString());
        }
    }
}
