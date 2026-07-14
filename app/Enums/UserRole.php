<?php

namespace App\Enums;

enum UserRole: int
{
    case ADMIN = 1;
    case ORGANIZER = 2;

    public function label(): string
    {
        return match($this) {
            self::ADMIN => 'Admin Utama',
            self::ORGANIZER => 'Organizer (EO)',
        };
    }

    public function badgeClass(): string
    {
        return match($this) {
            self::ADMIN => 'bg-amber-50 text-amber-700 border border-amber-100',
            self::ORGANIZER => 'bg-blue-50 text-blue-700 border border-blue-100',
        };
    }
}