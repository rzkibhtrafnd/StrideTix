<?php

namespace App\Models;
use App\Enums\EventStatus;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Casts\Attribute;

class Event extends Model
{
    protected $fillable = [
        'organizer_id',
        'title',
        'description',
        'province_id',
        'province_name',
        'regency_id',
        'regency_name',
        'location',
        'google_maps_url',
        'event_date',
        'status',
    ];

    protected $casts = [
        'event_date' => 'date',
        'status' => EventStatus::class,
    ];

    public function organizer(): BelongsTo
    {
        return $this->belongsTo(Organizer::class, 'organizer_id');
    }

    public function raceCategories(): HasMany
    {
        return $this->hasMany(RaceCategory::class, 'event_id');
    }

    protected function minPrice(): Attribute
    {
        return Attribute::make(
            get: function () {
                $minPrice = null;

                foreach ($this->raceCategories as $category) {
                    $catMin = $category->ticketTiers->min('price');
                    if ($catMin !== null) {
                        if ($minPrice === null || $catMin < $minPrice) {
                            $minPrice = $catMin;
                        }
                    }
                }

                return $minPrice;
            }
        );
    }

    public function scopePublished(Builder $query): Builder
    {
        return $query->where('status', EventStatus::PUBLISHED->value);
    }

    public function scopeFilter(Builder $query, array $filters): Builder
    {
        return $query->when($filters['search'] ?? null, function ($q, $search) {
            $q->where(function ($subQuery) use ($search) {
                $subQuery->where('title', 'like', '%' . $search . '%')
                        ->orWhere('location', 'like', '%' . $search . '%');
            });
        })->when($filters['province_id'] ?? null, function ($q, $provinceId) {
            $q->where('province_id', $provinceId);
        })->when($filters['regency_id'] ?? null, function ($q, $regencyId) {
            $q->where('regency_id', $regencyId);
        });
    }
}
