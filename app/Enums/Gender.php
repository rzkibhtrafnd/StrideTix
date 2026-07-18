<?php

namespace App\Enums;

enum Gender: int
{
    case MALE = 1;
    case FEMALE = 2;

    public function label(): string
    {
        return match($this) {
            self::MALE => 'Laki-laki',
            self::FEMALE => 'Perempuan',
        };
    }

    public function badgeClass(): string
    {
        return match($this) {
            self::MALE => 'bg-blue-50 text-blue-700 border border-blue-100',
            self::FEMALE => 'bg-pink-50 text-pink-700 border border-pink-100',
        };
    }

    public static function fromString(string $value): ?self
    {
        return match (strtoupper($value)) {
            'M', 'LAKI-LAKI', 'L' => self::MALE,
            'F', 'PEREMPUAN', 'P' => self::FEMALE,
            default => null,
        };
    }
}