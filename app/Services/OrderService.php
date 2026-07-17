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
            $this->releaseExpiredOrders();

            $totalOriginalPrice = 0;
            $itemsToCreate = [];

            foreach ($requestedTickets as $tierId => $quantity) {
                if ($quantity <= 0) continue;

                $tier = TicketTier::lockForUpdate()->findOrFail($tierId);

                if ($tier->slot_limit < $quantity) {
                    throw new Exception("Maaf, kuota kuota tiket untuk {$tier->tier_name} tidak mencukupi.");
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
            $order = Order::where('invoice_number', $invoiceNumber)
                ->where('payment_status', 'pending')
                ->whereDoesntHave('items.participants')
                ->first();

            if (!$order || Carbon::parse($order->created_at)->addMinutes(10)->isPast()) {
                $this->releaseExpiredOrders();
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

    public function releaseExpiredOrders(): void
    {
        $abandonedForms = Order::with('items.ticketTier')
            ->where('payment_status', 'pending')
            ->where('created_at', '<', Carbon::now()->subMinutes(10))
            ->whereDoesntHave('items.participants')
            ->get();

        foreach ($abandonedForms as $order) {
            foreach ($order->items as $item) {
                $item->ticketTier()->increment('slot_limit', $item->quantity);
            }
            $order->delete();
        }

        $expiredPayments = Order::with('items.ticketTier')
            ->where('payment_status', 'pending')
            ->where('updated_at', '<', Carbon::now()->subMinutes(7))
            ->whereHas('items.participants')
            ->get();

        foreach ($expiredPayments as $order) {
            foreach ($order->items as $item) {
                $item->ticketTier()->increment('slot_limit', $item->quantity);
            }
            $order->update(['payment_status' => 'expire']); 
        }
    }
}