<?php

namespace App\Enums;

enum EventStatus: int
{
    case DRAFT = 1;
    case PUBLISHED = 2;
    case COMPLETE = 3;
    case CANCELLED = 4;

    public function label(): string
    {
        return match($this) {
            self::DRAFT => 'Draft',
            self::PUBLISHED => 'Published',
            self::COMPLETE => 'Complete',
            self::CANCELLED => 'Cancelled',
        };
    }

    public function badgeClass(): string
    {
        return match($this) {
            self::DRAFT => 'bg-slate-100 text-slate-700 border border-slate-200',
            self::PUBLISHED => 'bg-green-50 text-green-700 border border-green-100',
            self::COMPLETE => 'bg-blue-50 text-blue-700 border border-blue-100',
            self::CANCELLED => 'bg-red-50 text-red-700 border border-red-100',
        };
    }
}