<?php

namespace App\Services;

use App\Models\RaceCategory;
use Illuminate\Pagination\LengthAwarePaginator;

class RaceCategoryService
{
    public function getAllCategories(int $perPage = 10): LengthAwarePaginator
    {
        return RaceCategory::with('event')->latest()->paginate($perPage);
    }

    public function createCategory(array $data): RaceCategory
    {
        $data['available_slot'] = $data['total_slot'];
        return RaceCategory::create($data);
    }

    public function updateCategory(RaceCategory $category, array $data): bool
    {
        $selisih = $data['total_slot'] - $category->total_slot;
        $data['available_slot'] = max(0, $category->available_slot + $selisih);

        return $category->update($data);
    }

    public function deleteCategory(RaceCategory $category): bool
    {
        return $category->delete();
    }
}