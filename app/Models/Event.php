<?php

namespace App\Models;
use App\Enums\EventStatus;
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
}
