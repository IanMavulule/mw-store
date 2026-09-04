<?php

namespace App\Enums;

enum Role : string
{
    case Admin = 'admin';
    case Manager = 'manager';
    case Client = 'client';
   
    public function label(): string
    {
        return match ($this) {
            self::Admin => 'Administrator',
            self::Manager => 'Manager',
            self::Client => 'Client',
        };
    }

    public static function values(): array
    {
        return array_column(self::cases(), 'value');
    }
}
