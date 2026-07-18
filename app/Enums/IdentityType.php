<?php

namespace App\Enums;

enum IdentityType: int
{
    case KTP = 1;
    case PASPOR = 2;

    public function label(): string
    {
        return match($this) {
            self::KTP => 'KTP',
            self::PASPOR => 'PASPOR',
        };
    }

    public function badgeClass(): string
    {
        return match($this) {
            self::KTP => 'bg-slate-50 text-slate-700 border border-slate-100',
            self::PASPOR => 'bg-indigo-50 text-indigo-700 border border-indigo-100',
        };
    }

    public static function fromString(string $value): ?self
    {
        return match (strtoupper($value)) {
            'KTP' => self::KTP,
            'PASPOR', 'PASSPORT' => self::PASPOR,
            default => null,
        };
    }
}