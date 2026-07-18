<?php

namespace App\Services;

use App\Models\Event;
use App\Enums\EventStatus;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Cache;

class FrontEventService
{
    public function getPublishedEvents(): Collection
    {
        return Cache::remember('events_published', 600, function () {
            return Event::with(['organizer', 'raceCategories.ticketTiers'])
                ->where('status', EventStatus::PUBLISHED->value)
                ->orderBy('event_date', 'asc')
                ->get();
        });
    }

    public function getEventDetails(int $id): Event
    {
        return Cache::remember("event_details_{$id}", 600, function () use ($id) {
            return Event::with(['organizer', 'raceCategories.ticketTiers'])
                ->where('status', EventStatus::PUBLISHED->value)
                ->findOrFail($id);
        });
    }
}