<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;
use App\Services\MidtransService;
use App\Services\OrderService;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;

class PaymentController extends Controller
{
    public function show(string $invoice, MidtransService $midtransService)
    {
        app(OrderService::class)->releaseExpiredOrders();

        $order = Order::with('items.ticketTier.raceCategory')
            ->where('invoice_number', $invoice)
            ->firstOrFail();

        if ($order->payment_status === 'pending' && Carbon::parse($order->updated_at)->addMinutes(7)->isPast()) {
            foreach ($order->items as $item) {
                $item->ticketTier()->increment('slot_limit', $item->quantity);
            }
            $order->update(['payment_status' => 'expire']);
        }

        if ($order->payment_status !== 'pending') {
            return redirect()->route('front.checkout.success', $order->invoice_number)
                ->with('error', 'Sesi pembayaran Anda telah kedaluwarsa atau sudah selesai.');
        }

        $snapToken = $midtransService->generateSnapToken($order);

        return view('front.checkout.payment', compact('order', 'snapToken'));
    }

    public function notification(Request $request)
    {
        $payload = $request->all();
        Log::info('Midtrans Webhook:', $payload);

        $orderId = $payload['order_id'];
        $transactionStatus = $payload['transaction_status'];

        $order = Order::with('items.ticketTier')->where('invoice_number', $orderId)->first();
        
        if (!$order) {
            return response()->json([
                'status' => 'error',
                'message' => 'Invoice ' . $orderId . ' tidak ditemukan di database. Pastikan order sudah terbuat!'
            ], 404);
        }

        if ($transactionStatus == 'capture' || $transactionStatus == 'settlement') {
            $order->update([
                'payment_status' => 'settlement',
                'midtrans_transaction_id' => $payload['transaction_id'] ?? null,
                'payment_method' => $payload['payment_type'] ?? null,
                'paid_at' => now(),
            ]);
            
            return response()->json(['status' => 'success', 'message' => 'Status berhasil diupdate menjadi settlement!']);
        } 
        
        if (in_array($transactionStatus, ['cancel', 'deny', 'expire'])) {
            if ($order->payment_status == 'pending') {
                foreach ($order->items as $item) {
                    $item->ticketTier()->increment('slot_limit', $item->quantity);
                }
                $order->update(['payment_status' => 'expire']);
            }
            
            return response()->json(['status' => 'success', 'message' => 'Status berhasil diubah menjadi expire!']);
        }

        return response()->json(['status' => 'ignored', 'message' => 'Status transaksi tidak memerlukan aksi.']);
    }
}