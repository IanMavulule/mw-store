<?php

namespace App\Enums;

enum SizeType: string
{
    case Letter = 'letter';
    case Numeric = 'numeric';

    public function label(): string
    {
        return match ($this) {
            self::Letter => 'Letter',
            self::Numeric => 'Numeric',
        };
    }

    public static function values(): array
    {
        return array_column(self::cases(), 'value');
    }
}
