<?php

namespace App\Services;

use App\Models\TicketTier;
use App\Models\RaceCategory;
use Illuminate\Support\Facades\DB;
use Illuminate\Pagination\LengthAwarePaginator;
use Exception;

class TicketTierService
{
    public function getAllTiers(array $filters = [], int $perPage = 10): LengthAwarePaginator
    {
        return TicketTier::with('raceCategory.event')
            ->filter($filters)
            ->latest()
            ->paginate($perPage);
    }

    public function createTier(array $data): TicketTier
    {
        return DB::transaction(function () use ($data) {
            $category = RaceCategory::lockForUpdate()->findOrFail($data['race_category_id']);
            
            $category->allocateSlots((int) $data['slot_limit']);

            return TicketTier::create($data);
        });
    }

    public function updateTier(TicketTier $tier, array $data): bool
    {
        return DB::transaction(function () use ($tier, $data) {
            $oldSlot = $tier->slot_limit;
            $newSlot = isset($data['slot_limit']) ? (int) $data['slot_limit'] : $oldSlot;

            if ($oldSlot !== $newSlot) {
                $category = RaceCategory::lockForUpdate()->findOrFail($tier->race_category_id);
                $category->adjustSlots($oldSlot, $newSlot);
            }

            return $tier->update($data);
        });
    }

    public function deleteTier(TicketTier $tier): bool
    {
        return DB::transaction(function () use ($tier) {
            if ($tier->orderItems()->exists()) {
                throw new Exception("Tiket ini tidak dapat dihapus karena sudah memiliki riwayat transaksi.");
            }

            $category = RaceCategory::lockForUpdate()->find($tier->race_category_id);
            if ($category) {
                $category->increment('available_slot', $tier->slot_limit);
            }
            
            return $tier->delete();
        });
    }
}