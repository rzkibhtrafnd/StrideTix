<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\View\View;

class TransactionHistoryController extends Controller
{
    public function index(Request $request): View
    {
        $transactions = Order::with(['items.ticketTier.raceCategory.event.organizer', 'user'])
            ->latest()
            ->filter($request->all())
            ->paginate(10)
            ->withQueryString();

        return view('admin.transactions.index', compact('transactions'));
    }

    public function show(Order $order): View
    {
        $order->load(['items.ticketTier.raceCategory.event.organizer', 'items.participants', 'user']);

        return view('admin.transactions.show', compact('order'));
    }
}