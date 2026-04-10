<?php

namespace App;

enum BusinessRole: string {

    case ADMIN = 'admin';
    case EMPLOYEE = 'employee';

    public function label(): string
    {
        return match ($this) {
            self::ADMIN => d_trans('Administrator'),
            self::EMPLOYEE => d_trans('Employee'),
        };
    }

    public static function values(): array
    {
        return array_column(self::cases(), 'value');
    }
}
