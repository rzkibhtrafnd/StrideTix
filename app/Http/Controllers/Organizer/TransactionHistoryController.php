<?php

namespace App\Http\Controllers\Organizer;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class TransactionHistoryController extends Controller
{
    public function index(Request $request): View
    {
        $organizerId = Auth::user()->organizer->id ?? null;

        $transactions = Order::with(['items.ticketTier.raceCategory.event', 'user'])
            ->latest()
            ->forOrganizer($organizerId)
            ->filter($request->all())
            ->paginate(10)
            ->withQueryString();

        return view('organizer.transactions.index', compact('transactions'));
    }

    public function show(Order $order): View
    {
        $organizerId = Auth::user()->organizer->id ?? null;

        $isOwned = Order::where('id', $order->id)->forOrganizer($organizerId)->exists();

        if (!$isOwned || !$organizerId) {
            abort(403, 'Anda tidak memiliki akses ke data transaksi ini.');
        }

        $order->load(['items.ticketTier.raceCategory.event.organizer', 'items.participants', 'user']);

        return view('organizer.transactions.show', compact('order'));
    }
}