<?php

namespace App\Services;

use App\Models\Order;
use App\Models\TicketTier;
use App\Models\Participant;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Carbon\Carbon;
use Exception;

class OrderService
{
    public function reserveTickets(array $requestedTickets): Order
    {
        return DB::transaction(function () use ($requestedTickets) {
            $totalOriginalPrice = 0;
            $itemsToCreate = [];

            foreach ($requestedTickets as $tierId => $quantity) {
                if ($quantity <= 0) continue;

                $tier = TicketTier::lockForUpdate()->findOrFail($tierId);

                if ($tier->slot_limit < $quantity) {
                    throw new Exception("Maaf, kuota tiket untuk {$tier->tier_name} tidak mencukupi.");
                }

                $tier->decrement('slot_limit', $quantity);

                $totalOriginalPrice += ($tier->price * $quantity);
                $itemsToCreate[] = [
                    'ticket_tier_id' => $tier->id,
                    'price' => $tier->price,
                    'quantity' => $quantity
                ];
            }

            if (empty($itemsToCreate)) {
                throw new Exception("Silakan pilih minimal 1 jenis tiket sebelum melanjutkan.");
            }

            $order = Order::create([
                'user_id' => Auth::id(),
                'invoice_number' => 'STX-' . strtoupper(Str::random(4)) . date('YmdHis'),
                'total_original_price' => $totalOriginalPrice,
                'gross_amount' => $totalOriginalPrice,
                'payment_status' => 'pending'
            ]);

            foreach ($itemsToCreate as $item) {
                $order->items()->create($item);
            }

            return $order;
        });
    }

    public function completeOrder(string $invoiceNumber, array $data): Order
    {
        return DB::transaction(function () use ($invoiceNumber, $data) {
            $order = Order::with('items.ticketTier')
                ->where('invoice_number', $invoiceNumber)
                ->where('payment_status', 'pending')
                ->whereDoesntHave('items.participants')
                ->first();

            if (!$order || Carbon::parse($order->created_at)->addMinutes(10)->isPast()) {
                if ($order) {
                    $this->releaseSingleOrder($order, true);
                }
                throw new Exception("Waktu pengisian formulir Anda telah habis (Batas 10 menit). Silakan pilih tiket kembali.");
            }

            $order->update([
                'customer_name' => $data['customer_name'],
                'customer_email' => $data['customer_email'],
                'customer_phone' => $data['customer_phone'],
            ]);

            $participantDataGroup = $data['participants'] ?? [];
            $participantIndex = 0;

            foreach ($order->items as $item) {
                for ($i = 0; $i < $item->quantity; $i++) {
                    if (isset($participantDataGroup[$participantIndex])) {
                        Participant::create(array_merge(
                            $participantDataGroup[$participantIndex],
                            ['order_item_id' => $item->id]
                        ));
                        $participantIndex++;
                    }
                }
            }

            return $order;
        });
    }

    public function checkAndProcessExpiredOrder(Order $order): void
    {
        if ($order->payment_status === 'pending' && Carbon::parse($order->updated_at)->addMinutes(7)->isPast()) {
            DB::transaction(function () use ($order) {
                $this->releaseSingleOrder($order, false);
            });
        }
    }

    public function releaseExpiredOrders(): void
    {
        DB::transaction(function () {
            Order::with('items.ticketTier')
                ->formAbandoned()
                ->lockForUpdate()
                ->get()
                ->each(fn($order) => $this->releaseSingleOrder($order, true));

            Order::with('items.ticketTier')
                ->paymentExpired()
                ->lockForUpdate()
                ->get()
                ->each(fn($order) => $this->releaseSingleOrder($order, false));
        });
    }

    private function releaseSingleOrder(Order $order, bool $isDelete): void
    {
        foreach ($order->items as $item) {
            $item->ticketTier()->increment('slot_limit', $item->quantity);
        }
        
        if ($isDelete) {
            $order->delete();
        } else {
            $order->update(['payment_status' => 'expire']);
        }
    }

    public function processMidtransNotification(array $payload): void
    {
        $orderId = $payload['order_id'] ?? null;
        $transactionStatus = $payload['transaction_status'] ?? null;
        $paymentType = $payload['payment_type'] ?? null;

        $order = Order::with('items.ticketTier')
            ->where('invoice_number', $orderId)
            ->firstOrFail();

        $vaNumber = null;
        $bankChannel = null;

        if ($paymentType === 'bank_transfer' && !empty($payload['va_numbers'])) {
            $vaNumber = $payload['va_numbers'][0]['va_number'] ?? null;
            $bankChannel = $payload['va_numbers'][0]['bank'] ?? null;
        } elseif ($paymentType === 'permata_va') {
            $vaNumber = $payload['permata_va_number'] ?? null;
            $bankChannel = 'permata';
        }

        $paymentStatus = $order->payment_status;
        $paidAt = $order->paid_at;

        if (in_array($transactionStatus, ['settlement', 'capture'])) {
            $paymentStatus = 'settlement';
            $paidAt = Carbon::now();
        } elseif (in_array($transactionStatus, ['deny', 'expire', 'cancel'])) {
            $paymentStatus = 'expire';
            $this->releaseSingleOrder($order, false);
        }

        $order->update([
            'payment_status' => $paymentStatus,
            'payment_method' => $paymentType,
            'midtrans_transaction_id' => $payload['transaction_id'] ?? null,
            'va_number' => $vaNumber,
            'payment_provider_channel' => $bankChannel,
            'paid_at' => $paidAt,
        ]);
    }
}