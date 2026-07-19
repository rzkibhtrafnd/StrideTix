<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Carbon\Carbon;

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

    protected function statusLabel(): Attribute
    {
        return Attribute::make(
            get: function () {
                $today = Carbon::today();
                
                $isSalesActive = $today->greaterThanOrEqualTo($this->start_date->startOfDay()) && $today->lessThanOrEqualTo($this->end_date->endOfDay());

                if (!$isSalesActive) {
                    return 'tutup';
                }

                if ($this->slot_limit <= 0) {
                    return 'habis';
                }

                return 'tersedia';
            }
        );
    }

    public function raceCategory(): BelongsTo
    {
        return $this->belongsTo(RaceCategory::class, 'race_category_id');
    }

    public function scopeFilter($query, array $filters)
    {
        return $query->when($filters['search'] ?? null, function ($q, $search) {
            $q->where(function ($subQuery) use ($search) {
                $subQuery->where('tier_name', 'like', '%' . $search . '%')
                        ->orWhereHas('raceCategory', function ($catQuery) use ($search) {
                            $catQuery->where('category_name', 'like', '%' . $search . '%')
                                    ->orWhereHas('event', function ($eventQuery) use ($search) {
                                        $eventQuery->where('title', 'like', '%' . $search . '%');
                                    });
                        });
            });
        })->when($filters['race_category_id'] ?? null, function ($q, $categoryId) {
            $q->where('race_category_id', $categoryId);
        });
    }
}