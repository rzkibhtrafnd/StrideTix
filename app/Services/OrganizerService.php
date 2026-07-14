<?php

namespace App\Services;

use App\Models\Organizer;
use Illuminate\Support\Facades\Storage;
use Illuminate\Pagination\LengthAwarePaginator;

class OrganizerService
{
    public function getAllOrganizers(int $perPage = 10): LengthAwarePaginator
    {
        return Organizer::with('user')->latest()->paginate($perPage);
    }

    public function createOrganizer(array $data, $logoFile = null): Organizer
    {
        if ($logoFile) {
            $data['logo'] = $logoFile->store('organizer_logos', 'public');
        }

        return Organizer::create($data);
    }

    public function updateOrganizer(Organizer $organizer, array $data, $logoFile = null): bool
    {
        if ($logoFile) {
            if ($organizer->logo) {
                Storage::disk('public')->delete($organizer->logo);
            }
            $data['logo'] = $logoFile->store('organizer_logos', 'public');
        }

        return $organizer->update($data);
    }

    public function deleteOrganizer(Organizer $organizer): bool
    {
        if ($organizer->logo) {
            Storage::disk('public')->delete($organizer->logo);
        }
        return $organizer->delete();
    }
}