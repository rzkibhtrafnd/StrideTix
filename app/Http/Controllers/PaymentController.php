<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Services\MidtransService;
use App\Services\OrderService;
use App\Http\Requests\MidtransNotificationRequest;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class PaymentController extends Controller
{
    public function __construct(
        protected OrderService $orderService,
        protected MidtransService $midtransService
    ) {}

    public function show(string $invoice): View|RedirectResponse
    {
        $this->orderService->releaseExpiredOrders();

        $order = Order::with('items.ticketTier.raceCategory')
            ->where('invoice_number', $invoice)
            ->firstOrFail();

        $this->orderService->checkAndProcessExpiredOrder($order);

        if ($order->payment_status !== 'pending') {
            return redirect()->route('front.checkout.success', $order->invoice_number)
                ->with('error', 'Sesi pembayaran Anda telah kedaluwarsa atau sudah selesai.');
        }

        $snapToken = $this->midtransService->generateSnapToken($order);

        return view('front.checkout.payment', compact('order', 'snapToken'));
    }

    public function notification(MidtransNotificationRequest $request): JsonResponse
    {
        $this->orderService->processMidtransNotification($request->all());

        return response()->json([
            'status' => 'success',
            'message' => 'Midtrans Webhook berhasil diproses'
        ]);
    }
}