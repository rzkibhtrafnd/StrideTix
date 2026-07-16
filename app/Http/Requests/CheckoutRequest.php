<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CheckoutRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'customer_name' => ['required', 'string', 'max:255'],
            'customer_email' => ['required', 'email', 'max:255'],
            'customer_phone' => ['required', 'string', 'max:20'],
            
            'participants' => ['required', 'array'],
            'participants.*.full_name' => ['required', 'string', 'max:255'],
            'participants.*.gender' => ['required', 'in:M,F'],
            'participants.*.date_of_birth' => ['required', 'date'],
            'participants.*.identity_type' => ['required', 'in:KTP,PASPOR'],
            'participants.*.identity_number' => ['required', 'string', 'max:50'],
            'participants.*.blood_type' => ['required', 'in:A,B,AB,O'],
            'participants.*.jersey_size' => ['required', 'in:XS,S,M,L,XL,XXL'],
            'participants.*.emergency_contact_name' => ['required', 'string', 'max:255'],
            'participants.*.emergency_contact_phone' => ['required', 'string', 'max:20'],
            'participants.*.emergency_relation' => ['required', 'string', 'max:100'],
        ];
    }

    public function messages(): array
    {
        return [
            'participants.*.full_name.required' => 'Nama lengkap pelari wajib diisi.',
            'participants.*.identity_number.required' => 'Nomor identitas pelari wajib diisi.',
            'participants.*.emergency_contact_phone.required' => 'Nomor kontak darurat pelari wajib diisi.',
        ];
    }
}