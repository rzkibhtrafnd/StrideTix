<?php

namespace App\Http\Controllers;

use App\Services\FrontEventService;
use App\Services\IndonesianRegionService;
use Illuminate\View\View;
use Illuminate\Http\Request;

class FrontEventController extends Controller
{
    public function __construct(
        protected FrontEventService $frontEventService,
        protected IndonesianRegionService $regionService
    ) {}

    public function index(): View
    {
        $events = $this->frontEventService->getLatestPublishedEvents();
        return view('welcome', compact('events'));
    }

    public function explore(Request $request): View
    {
        $filters = $request->only(['search', 'province_id', 'regency_id']);

        $events = $this->frontEventService->searchAndPaginateEvents($filters, 12);

        $provinces = $this->regionService->fetchProvinces();

        return view('front.events.explore', compact('events', 'filters', 'provinces'));
    }

    public function show(int $id): View
    {
        $event = $this->frontEventService->getEventDetails($id);
        return view('front.events.show', compact('event'));
    }
}