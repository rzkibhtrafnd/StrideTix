<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class RaceCategoryRequest extends FormRequest
{
    public function authorize(): bool
    {
        return Auth::check();
    }

    public function rules(): array
    {
        return [
            'event_id'      => 'required|exists:events,id',
            'category_name' => 'required|string|max:100',
            'distance_km'   => 'required|string|max:20',
            'total_slot'    => 'required|integer|min:1',
        ];
    }

    public function messages(): array
    {
        return [
            'event_id.required'      => 'Event induk wajib dikaitkan.',
            'category_name.required' => 'Nama kategori lari wajib diisi (misal: Full Marathon).',
            'distance_km.required'   => 'Jarak tempuh lintasan lomba wajib ditentukan.',
            'total_slot.required'    => 'Total kuota slot tiket wajib ditentukan.',
            'total_slot.integer'     => 'Kuota harus berupa angka numerik.',
        ];
    }
}