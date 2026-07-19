<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Event;
use App\Models\Organizer;
use App\Services\EventService;
use App\Services\IndonesianRegionService;
use App\Http\Requests\EventRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;
use Illuminate\Http\Request;

class EventController extends Controller
{
    public function __construct(
        protected EventService $eventService,
        protected IndonesianRegionService $regionService
    ) {}

    public function index(Request $request): View
    {
        $filters = $request->only(['search', 'province_id', 'regency_id']);
        $events = $this->eventService->getAllEvents($filters);
        
        $provinces = $this->regionService->fetchProvinces();

        return view('admin.events.index', compact('events', 'provinces', 'filters'));
    }

    public function create(): View
    {
        $organizers = Organizer::latest()->get();
        return view('admin.events.create', compact('organizers'));
    }

    public function store(EventRequest $request): RedirectResponse
    {
        $this->eventService->createEvent($request->validated());
        return redirect()->route('admin.events.index')->with('success', 'Event lari baru berhasil diterbitkan.');
    }

    public function show(Event $event): View
    {
        $event->load(['organizer', 'raceCategories.ticketTiers']);
        return view('admin.events.show', compact('event'));
    }

    public function edit(Event $event): View
    {
        $organizers = Organizer::latest()->get();
        return view('admin.events.edit', compact('event', 'organizers'));
    }

    public function update(EventRequest $request, Event $event): RedirectResponse
    {
        $this->eventService->updateEvent($event, $request->validated());
        return redirect()->route('admin.events.index')->with('success', 'Data informasi event berhasil diperbarui.');
    }

    public function destroy(Event $event): RedirectResponse
    {
        $this->eventService->deleteEvent($event);
        return redirect()->route('admin.events.index')->with('success', 'Event berhasil dihapus dari sistem.');
    }
}