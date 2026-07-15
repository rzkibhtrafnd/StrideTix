<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class TicketTier extends Model
{
    protected $fillable = [
        'race_category_id',
        'tier_name',
        'price',
        'start_date',
        'end_date',
        'slot_limit',
    ];

    protected function casts(): array
    {
        return [
            'price' => 'float',
            'start_date' => 'date',
            'end_date' => 'date',
            'slot_limit' => 'integer',
        ];
    }

    public function raceCategory(): BelongsTo
    {
        return $this->belongsTo(RaceCategory::class, 'race_category_id');
    }
}