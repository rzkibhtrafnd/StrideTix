<?php

namespace App\Services;

use App\Models\TicketTier;
use App\Models\RaceCategory;
use Illuminate\Support\Facades\DB;
use Illuminate\Pagination\LengthAwarePaginator;

class TicketTierService
{
    public function getAllTiers(int $perPage = 10): LengthAwarePaginator
    {
        return TicketTier::with('raceCategory.event')->latest()->paginate($perPage);
    }

    public function createTier(array $data): TicketTier
    {
        return DB::transaction(function () use ($data) {
            $tier = TicketTier::create($data);

            $category = RaceCategory::lockForUpdate()->find($tier->race_category_id);
            $category->decrement('available_slot', $tier->slot_limit);

            return $tier;
        });
    }

    public function updateTier(TicketTier $tier, array $data): bool
    {
        return DB::transaction(function () use ($tier, $data) {
            $oldSlot = $tier->slot_limit;
            $newSlot = (int) $data['slot_limit'];
            
            $tier->update($data);

            if ($oldSlot !== $newSlot) {
                $selisih = $newSlot - $oldSlot;
                $category = RaceCategory::lockForUpdate()->find($tier->race_category_id);
                $category->decrement('available_slot', $selisih);
            }

            return true;
        });
    }

    public function deleteTier(TicketTier $tier): bool
    {
        return DB::transaction(function () use ($tier) {
            $category = RaceCategory::lockForUpdate()->find($tier->race_category_id);
            if ($category) {
                $category->increment('available_slot', $tier->slot_limit);
            }
            return $tier->delete();
        });
    }
}