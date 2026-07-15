<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\TicketTier;
use App\Models\RaceCategory;
use App\Services\TicketTierService;
use App\Http\Requests\TicketTierRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class TicketTierController extends Controller
{
    public function __construct(
        protected TicketTierService $tierService
    ) {}

    public function index(): View
    {
        $tiers = $this->tierService->getAllTiers();
        return view('admin.ticket_tiers.index', compact('tiers'));
    }

    public function create(): View
    {
        $categories = RaceCategory::with('event')
            ->where('available_slot', '>', 0)
            ->latest()
            ->get();
        return view('admin.ticket_tiers.create', compact('categories'));
    }

    public function store(TicketTierRequest $request): RedirectResponse
    {
        $this->tierService->createTier($request->validated());
        return redirect()->route('admin.ticket-tiers.index')->with('success', 'Tier tingkatan tiket berhasil diterbitkan.');
    }

    public function edit(TicketTier $ticketTier): View
    {
        $categories = RaceCategory::with('event')
            ->where('available_slot', '>', 0)
            ->orWhere('id', $ticketTier->race_category_id)
            ->latest()
            ->get();
        return view('admin.ticket_tiers.edit', compact('ticketTier', 'categories'));
    }

    public function update(TicketTierRequest $request, TicketTier $ticketTier): RedirectResponse
    {
        $this->tierService->updateTier($ticketTier, $request->validated());
        return redirect()->route('admin.ticket-tiers.index')->with('success', 'Konfigurasi tier tiket berhasil diubah.');
    }

    public function destroy(TicketTier $ticketTier): RedirectResponse
    {
        $this->tierService->deleteTier($ticketTier);
        return redirect()->route('admin.ticket-tiers.index')->with('success', 'Tier tiket berhasil dihapus & alokasi slot dikembalikan.');
    }
}