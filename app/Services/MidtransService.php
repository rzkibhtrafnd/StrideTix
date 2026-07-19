<?php

namespace App\Services;

use App\Models\Order;
use Midtrans\Config;
use Midtrans\Snap;
use Exception;

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
            ],
            'enabled_payments' => [
                'bank_transfer', 
                'bca_va', 
                'bni_va', 
                'bri_va', 
                'cimb_va', 
                'mandiri_clickpay', 
                'qris', 
                'gopay'
            ]
        ];

        $snapToken = Snap::getSnapToken($params);
        
        $order->update(['midtrans_snap_token' => $snapToken]);

        return $snapToken;
    }

    public function isValidSignature(array $payload): bool
    {
        if (!isset($payload['signature_key'], $payload['order_id'], $payload['status_code'], $payload['gross_amount'])) {
            return false;
        }

        $localSignature = hash("sha512", 
            $payload['order_id'] . 
            $payload['status_code'] . 
            $payload['gross_amount'] . 
            config('midtrans.server_key')
        );

        return $localSignature === $payload['signature_key'];
    }
}