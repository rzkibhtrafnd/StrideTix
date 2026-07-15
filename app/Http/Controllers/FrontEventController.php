<?php

namespace App\Http\Controllers;

use App\Services\FrontEventService;
use Illuminate\View\View;

class FrontEventController extends Controller
{
    public function __construct(
        protected FrontEventService $frontEventService
    ) {}

    public function index(): View
    {
        $events = $this->frontEventService->getPublishedEvents();
        return view('welcome', compact('events'));
    }

    public function show(int $id): View
    {
        $event = $this->frontEventService->getEventDetails($id);
        return view('front.events.show', compact('event'));
    }
}