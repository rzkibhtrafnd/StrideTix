<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class MidtransNotificationRequest extends FormRequest
{
    public function authorize(): bool
    {
        $payload = $this->all();
        
        $incomingSignature = $payload['signature_key'] ?? '';

        if (app()->environment('local') && $incomingSignature === 'dummy_signature_key_untuk_testing_lokal') {
            return true;
        }

        $orderId     = $payload['order_id'] ?? '';
        $statusCode  = $payload['status_code'] ?? '';
        $grossAmount = $payload['gross_amount'] ?? '';
        
        $serverKey   = env('MIDTRANS_SERVER_KEY'); 

        $computedSignature = hash("sha512", $orderId . $statusCode . $grossAmount . $serverKey);

        return $incomingSignature === $computedSignature;
    }

    public function rules(): array
    {
        return [
            'order_id'           => ['required', 'string'],
            'transaction_status' => ['required', 'string'],
            'transaction_id'     => ['required', 'string'],
        ];
    }
}