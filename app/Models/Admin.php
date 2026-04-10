<?php

namespace App\Models;

use App\Classes\AvatarGenerator;
use App\Notifications\ResetPasswordNotification;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class Admin extends Authenticatable
{
    use Notifiable;

    const TWO_FACTOR_DISABLED = 0;
    const TWO_FACTOR_ACTIVE = 1;

    public function isTwoFactorDisabled()
    {
        return $this->two_factor_status == self::TWO_FACTOR_DISABLED;
    }

    public function isTwoFactorActive()
    {
        return $this->two_factor_status == self::TWO_FACTOR_ACTIVE;
    }

    protected $fillable = [
        'firstname',
        'lastname',
        'username',
        'email',
        'avatar',
        'password',
        'two_factor_status',
        'two_factor_secret',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected function casts(): array
    {
        return [
            'password' => 'hashed',
            'two_factor_status' => 'boolean',
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

    public function getAvatar()
    {
        if ($this->avatar) {
            return asset($this->avatar);
        }

        return AvatarGenerator::gravatar($this->email);
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

    public function sendPasswordResetNotification($token)
    {
        $this->notify(new ResetPasswordNotification($token, 'admin.password.reset'));
    }
}
