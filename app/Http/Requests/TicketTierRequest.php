<?php

namespace App\Http\Requests;

use App\Models\RaceCategory;
use Illuminate\Foundation\Http\FormRequest;

class TicketTierRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $raceCategoryId = $this->input('race_category_id');
        $currentTier = $this->route('ticket_tier');
        
        $category = RaceCategory::find($raceCategoryId);
        
        $maxAvailable = $category ? $category->available_slot : 0;
        if ($currentTier) {
            $maxAvailable += $currentTier->slot_limit;
        }

        return [
            'race_category_id' => 'required|exists:race_categories,id',
            'tier_name'        => 'required|string|max:100',
            'price'            => 'required|numeric|min:0',
            'start_date'       => 'required|date',
            'end_date'         => 'required|date|after_or_equal:start_date',
            'slot_limit'       => 'required|integer|min:1|max:' . $maxAvailable,
        ];
    }

    public function messages(): array
    {
        return [
            'race_category_id.required' => 'Kategori balapan wajib dipilih.',
            'tier_name.required'        => 'Nama tingkatan tiket wajib diisi (misal: Early Bird).',
            'price.required'            => 'Harga tiket harus diisi.',
            'end_date.after_or_equal'   => 'Tanggal akhir penjualan tidak boleh mendahului tanggal mulai.',
            'slot_limit.max'            => 'Kuota tiket melebihi sisa alokasi kuota kategori balapan yang tersedia.',
        ];
    }
}