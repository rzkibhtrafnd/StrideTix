<?php

namespace App\Services;

use App\Models\Event;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Cache;

class FrontEventService
{
    public function getLatestPublishedEvents(): Collection
    {
        return Cache::remember('events_home_latest_8', 600, function () {
            return Event::with(['organizer', 'raceCategories.ticketTiers'])
                ->published()
                ->orderBy('event_date', 'asc')
                ->limit(8)
                ->get();
        });
    }

    public function searchAndPaginateEvents(array $filters, int $perPage = 12): LengthAwarePaginator
    {
        return Event::with(['organizer', 'raceCategories.ticketTiers'])
            ->published()
            ->filter($filters)
            ->orderBy('event_date', 'asc')
            ->paginate($perPage);
    }

    public function getEventDetails(int $id): Event
    {
        return Cache::remember("event_details_{$id}", 600, function () use ($id) {
            return Event::with(['organizer', 'raceCategories.ticketTiers'])
                ->published()
                ->findOrFail($id);
        });
    }
}