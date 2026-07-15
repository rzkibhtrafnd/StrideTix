<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class RaceCategory extends Model
{
    protected $fillable = [
        'event_id',
        'category_name',
        'distance_km',
        'total_slot',
        'available_slot',
    ];

    protected function casts(): array
    {
        return [
            'total_slot' => 'integer',
            'available_slot' => 'integer',
        ];
    }

    public function event(): BelongsTo
    {
        return $this->belongsTo(Event::class, 'event_id');
    }

    public function ticketTiers(): HasMany
    {
        return $this->hasMany(TicketTier::class, 'race_category_id');
    }
}