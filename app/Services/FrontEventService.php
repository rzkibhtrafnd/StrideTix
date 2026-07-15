<?php

namespace App\Services;

use App\Models\Event;
use App\Enums\EventStatus;
use Illuminate\Database\Eloquent\Collection;

class FrontEventService
{
    public function getPublishedEvents(): Collection
    {
        return Event::with(['organizer', 'raceCategories.ticketTiers'])
            ->where('status', EventStatus::PUBLISHED->value)
            ->orderBy('event_date', 'asc')
            ->get();
    }

    public function getEventDetails(int $id): Event
    {
        return Event::with(['organizer', 'raceCategories.ticketTiers'])
            ->where('status', EventStatus::PUBLISHED->value)
            ->findOrFail($id);
    }
}