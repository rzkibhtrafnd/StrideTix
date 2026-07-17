<?php

namespace App\Services;

use App\Models\Order;
use Midtrans\Config;
use Midtrans\Snap;

class MidtransService
{
    public function __construct()
    {
        Config::$serverKey = config('midtrans.server_key');
        Config::$isProduction = config('midtrans.is_production');
        Config::$isSanitized = config('midtrans.is_sanitized');
        Config::$is3ds = config('midtrans.is_3ds');
    }

    public function generateSnapToken(Order $order): string
    {
        if ($order->midtrans_snap_token) {
            return $order->midtrans_snap_token;
        }

        $params = [
            'transaction_details' => [
                'order_id' => $order->invoice_number,
                'gross_amount' => (int) $order->gross_amount,
            ],
            'customer_details' => [
                'first_name' => $order->customer_name,
                'email' => $order->customer_email,
                'phone' => $order->customer_phone,
            ],
            'expiry' => [
                'start_time' => date("Y-m-d H:i:s O"),
                'unit' => 'minute',
                'duration' => 7
            ]
        ];

        $snapToken = Snap::getSnapToken($params);
        
        $order->update(['midtrans_snap_token' => $snapToken]);

        return $snapToken;
    }
}