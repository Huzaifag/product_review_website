<?php

namespace App\Enums;

enum BooleanEnum: string
{
    case YES = 'yes';
    case NO = 'no';

    public function getGermanLabel(): string
    {
        return match ($this) {
            self::YES => 'ja',
            self::NO => 'nein',
        };
    }

    public static function getHtml($value): string
    {
        if (is_null($value) || $value === '') {
            return '<span class="bool-na">—</span>';
        }

        // Map true/false/1/0 to the enum cases
        if ($value === true || $value === 1 || $value === '1') {
            $enum = self::YES;
        } elseif ($value === false || $value === 0 || $value === '0') {
            $enum = self::NO;
        } else {
            $valStr = strtolower(trim((string) $value));
            $enum = self::tryFrom($valStr);
        }

        if ($enum === self::YES) {
            return '<span class="bool-y">✓ '.d_trans('ja').'</span>';
        } elseif ($enum === self::NO) {
            return '<span class="bool-n">✗ '.d_trans('nein').'</span>';
        }

        return '<span class="bool-na">—</span>';
    }
}
