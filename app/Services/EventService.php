<?php

namespace App\Services;

use App\Models\Event;
use Illuminate\Pagination\LengthAwarePaginator;

class EventService
{
    public function getAllEvents(int $perPage = 10): LengthAwarePaginator
    {
        return Event::with('organizer')->latest()->paginate($perPage);
    }

    public function createEvent(array $data): Event
    {
        return Event::create($data);
    }

    public function updateEvent(Event $event, array $data): bool
    {
        return $event->update($data);
    }

    public function deleteEvent(Event $event): bool
    {
        return $event->delete();
    }
}