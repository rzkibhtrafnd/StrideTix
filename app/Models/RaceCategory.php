<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Exception;

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

    public function scopeFilter($query, array $filters)
    {
        return $query->when($filters['search'] ?? null, function ($q, $search) {
            $q->where(function ($subQuery) use ($search) {
                $subQuery->where('category_name', 'like', '%' . $search . '%')
                        ->orWhereHas('event', function ($eventQuery) use ($search) {
                            $eventQuery->where('title', 'like', '%' . $search . '%');
                        });
            });
        })->when($filters['event_id'] ?? null, function ($q, $eventId) {
            $q->where('event_id', $eventId);
        });
    }

    public function updateSlots(int $newTotalSlot): void
    {
        $bookedSlots = $this->total_slot - $this->available_slot;

        if ($newTotalSlot < $bookedSlots) {
            throw new Exception("Total slot baru ({$newTotalSlot}) tidak boleh kurang dari slot yang sudah dipesan ({$bookedSlots}).");
        }

        $this->total_slot = $newTotalSlot;
        $this->available_slot = $newTotalSlot - $bookedSlots;
    }

    public function allocateSlots(int $slots): void
    {
        if ($slots > $this->available_slot) {
            throw new Exception("Kuota tidak mencukupi. Sisa slot kategori saat ini hanya tinggal {$this->available_slot}.");
        }

        $this->decrement('available_slot', $slots);
    }

    public function adjustSlots(int $oldSlot, int $newSlot): void
    {
        $selisih = $newSlot - $oldSlot;

        if ($selisih > 0 && $selisih > $this->available_slot) {
            throw new Exception("Gagal memperbarui. Penambahan tiket sebesar {$selisih} slot melebihi sisa slot kategori ({$this->available_slot}).");
        }

        $this->decrement('available_slot', $selisih);
    }
}