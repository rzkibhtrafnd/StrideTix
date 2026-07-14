<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;
use App\Enums\UserRole;
use App\Enums\EventStatus;
use Illuminate\Validation\Rules\Enum;

class EventRequest extends FormRequest
{
    public function authorize(): bool
    {
        return Auth::user()?->role === UserRole::ADMIN;
    }

    public function rules(): array
    {
        return [
            'organizer_id' => 'required|exists:users,id',
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'location' => 'required|string|max:255',
            'google_maps_url' => 'nullable|url|max:255',
            'event_date' => 'required|date|after_or_equal:today',
            'status'          => ['required', new Enum(EventStatus::class)],
        ];
    }

    public function messages(): array
    {
        return [
            'title.required' => 'Judul event wajib diisi.',
            'location.required' => 'Lokasi tempat pelaksanaan wajib diisi.',
            'event_date.required' => 'Tanggal pelaksanaan event wajib ditentukan.',
            'event_date.after_or_equal' => 'Tanggal event tidak boleh di masa lalu.',
            'status.in' => 'Status event yang dipilih tidak valid.',
        ];
    }
}