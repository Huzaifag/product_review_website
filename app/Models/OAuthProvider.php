<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OAuthProvider extends Model
{
    protected $table = "oauth_providers";

    const STATUS_DISABLED = 0;
    const STATUS_ACTIVE = 1;

    protected static function boot()
    {
        parent::boot();

        static::saved(function ($provider) {
            switch ($provider->alias) {
                case 'facebook':
                    setEnv('FACEBOOK_CLIENT_ID', $provider->credentials->client_id);
                    setEnv('FACEBOOK_CLIENT_SECRET', $provider->credentials->client_secret);
                    break;
                case 'google':
                    setEnv('GOOGLE_CLIENT_ID', $provider->credentials->client_id);
                    setEnv('GOOGLE_CLIENT_SECRET', $provider->credentials->client_secret);
                    break;
                case 'microsoft':
                    setEnv('MICROSOFT_CLIENT_ID', $provider->credentials->client_id);
                    setEnv('MICROSOFT_CLIENT_SECRET', $provider->credentials->client_secret);
                    break;
                case 'vkontakte':
                    setEnv('VKONTAKTE_CLIENT_ID', $provider->credentials->client_id);
                    setEnv('VKONTAKTE_CLIENT_SECRET', $provider->credentials->client_secret);
                    break;
            }
        });
    }

    public function scopeDisabled($query)
    {
        $query->where('status', self::STATUS_DISABLED);
    }

    public function isDisabled()
    {
        return $this->status == self::STATUS_DISABLED;
    }

    public function scopeActive($query)
    {
        $query->where('status', self::STATUS_ACTIVE);
    }

    public function isActive()
    {
        return $this->status == self::STATUS_ACTIVE;
    }

    protected $fillable = [
        'credentials',
        'status',
    ];

    protected function casts(): array
    {
        return [
            'credentials' => 'object',
            'parameters' => 'object',
            'status' => 'boolean',
        ];
    }

    public function getLogoLink()
    {
        return asset($this->logo);
    }

    public static function getAvailableStatues()
    {
        return [
            self::STATUS_ACTIVE => d_trans('Active'),
            self::STATUS_DISABLED => d_trans('Disabled'),
        ];
    }

    public function getStatusName()
    {
        return self::getAvailableStatues()[$this->status];
    }
}
