<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\CheckoutRequest;
use App\Models\Event;
use App\Models\Order;
use App\Services\OrderService;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;
use Carbon\Carbon;
use Exception;
use Barryvdh\DomPDF\Facade\Pdf; 

class CheckoutController extends Controller
{
    public function __construct(
        protected OrderService $orderService
    ) {}

    public function showTicketPage(int $id): View
    {
        $this->orderService->releaseExpiredOrders();

        $event = Event::with('raceCategories.ticketTiers')->findOrFail($id);
        return view('front.checkout.ticket', compact('event'));
    }

    public function showCustomerForm(Request $request, int $id): RedirectResponse
    {
        $tickets = $request->input('tickets', []);
        $selectedTickets = array_filter($tickets, fn($q) => $q > 0);

        if (empty($selectedTickets)) {
            return redirect()->route('front.checkout.ticket', $id)
                ->with('error', 'Silakan tentukan minimal 1 kuantitas tiket untuk melanjutkan.');
        }

        try {
            $order = $this->orderService->reserveTickets($tickets);

            return redirect()->route('front.checkout.form.get', ['id' => $id, 'invoice' => $order->invoice_number]);

        } catch (Exception $e) {
            return redirect()->back()->with('error', $e->getMessage());
        }
    }

    public function renderCustomerForm(int $id, string $invoice)
    {
        $order = Order::with('items.ticketTier.raceCategory')
            ->where('invoice_number', $invoice)
            ->where('payment_status', 'pending')
            ->whereDoesntHave('items.participants')
            ->first();

        if (!$order || Carbon::parse($order->created_at)->addMinutes(10)->isPast()) {
            $this->orderService->releaseExpiredOrders();
            return redirect()->route('front.checkout.ticket', $id)
                ->with('error', 'Sesi booking tiket Anda telah berakhir atau tidak valid. Silakan pilih kembali.');
        }

        $event = Event::findOrFail($id);
        
        $expirationTime = Carbon::parse($order->created_at)->addMinutes(10);
        $secondsLeft = max(0, Carbon::now()->diffInSeconds($expirationTime, false));

        return view('front.checkout.form', compact('event', 'order', 'secondsLeft'));
    }

    public function store(CheckoutRequest $request, string $invoice): RedirectResponse
    {
        try {
            $order = $this->orderService->completeOrder($invoice, $request->validated());
            
            return redirect()->route('front.checkout.payment', $order->invoice_number);

        } catch (Exception $e) {
            return redirect()->back()
                ->with('error', $e->getMessage())
                ->withInput();
        }
    }

    public function showSuccessPage(string $invoice_number): View|RedirectResponse
    {
        $order = Order::with('items.ticketTier.raceCategory')
            ->where('invoice_number', $invoice_number)
            ->firstOrFail();

        if ($order->payment_status !== 'settlement') {
            return redirect()->route('front.checkout.payment', $order->invoice_number)
                ->with('error', 'Silakan selesaikan pembayaran terlebih dahulu.');
        }

        return view('front.checkout.success', compact('order'));
    }

    public function downloadInvoice(string $invoice_number)
    {
        $order = Order::with([
            'items.ticketTier.raceCategory.event', 
            'items.participants'
        ])->where('invoice_number', $invoice_number)->firstOrFail();

        if ($order->payment_status !== 'settlement') {
            return redirect()->route('front.checkout.payment', $order->invoice_number)
                ->with('error', 'Selesaikan pembayaran terlebih dahulu sebelum mengunduh invoice resmi.');
        }

        $event = $order->items->first()?->ticketTier?->raceCategory?->event;

        $pdf = Pdf::loadView('front.checkout.invoice-pdf', compact('order', 'event'))
            ->setPaper('a4', 'portrait');

        return $pdf->stream('Invoice-' . $order->invoice_number . '.pdf');
    }
}