<?php

namespace App\Services;

use App\Models\RaceCategory;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\DB;
use Exception;

class RaceCategoryService
{
    public function getAllCategories(array $filters = [], int $perPage = 10): LengthAwarePaginator
    {
        return RaceCategory::with('event')
            ->filter($filters)
            ->latest()
            ->paginate($perPage);
    }

    public function createCategory(array $data): RaceCategory
    {
        $data['available_slot'] = $data['total_slot'];
        
        return RaceCategory::create($data);
    }

    public function updateCategory(RaceCategory $category, array $data): bool
    {
        return DB::transaction(function () use ($category, $data) {
            if (isset($data['total_slot'])) {
                $category->updateSlots((int)$data['total_slot']);
            }

            return $category->fill($data)->save();
        });
    }

    public function deleteCategory(RaceCategory $category): bool
    {
        if ($category->available_slot < $category->total_slot) {
            throw new Exception("Kategori tidak dapat dihapus karena sudah ada peserta yang terdaftar.");
        }

        return $category->delete();
    }
}