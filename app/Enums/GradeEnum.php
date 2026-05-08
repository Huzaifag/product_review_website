<?php

namespace App\Enums;

enum GradeEnum: string
{
    case EXCELLENT = 'excellent';
    case VERY_GOOD = 'very_good';
    case GOOD = 'good';
    case SATISFACTORY = 'satisfactory';
    case ADEQUATE = 'adequate';
    case POOR = 'poor';
    case BAD = 'bad';
    case FAILING = 'failing';

    public function getGermanLabel(): string
    {
        return match ($this) {
            self::EXCELLENT, self::VERY_GOOD => 'Sehr gut',
            self::GOOD => 'Gut',
            self::SATISFACTORY => 'Befriedigend',
            self::ADEQUATE => 'Ausreichend',
            self::POOR, self::BAD => 'Mangelhaft',
            self::FAILING => 'Ungenuegend',
        };
    }

    public function getColorClass(): string
    {
        return match ($this) {
            self::EXCELLENT, self::VERY_GOOD, self::GOOD => 'gc-good',
            self::POOR, self::BAD, self::FAILING => 'gc-poor',
            default => 'gc-ok',
        };
    }

    public static function getLabel(string $grade): string
    {
        $grade = strtolower(trim($grade));
        $enum = self::tryFrom($grade);

        return $enum ? $enum->getGermanLabel() : str_replace('_', ' ', ucfirst($grade));
    }

    public static function getClass(string $grade): string
    {
        $grade = strtolower(trim($grade));
        $enum = self::tryFrom($grade);

        return $enum ? $enum->getColorClass() : 'gc-ok';
    }
}
