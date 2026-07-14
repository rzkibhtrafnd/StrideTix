<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;
use App\Enums\UserRole;

class OrganizerRequest extends FormRequest
{
    public function authorize(): bool
    {
        return Auth::user()?->role === UserRole::ADMIN;
    }

    public function rules(): array
    {
        $rules = [
            'user_id' => 'required|exists:users,id',
            'company_name' => 'required|string|max:255',
        ];

        if ($this->isMethod('POST')) {
            $rules['logo'] = 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048';
        } else {
            $rules['logo'] = 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048';
        }

        return $rules;
    }

    public function messages(): array
    {
        return [
            'user_id.required' => 'Akun pengguna utama wajib ditautkan.',
            'company_name.required' => 'Nama instansi/perusahaan penyelenggara wajib diisi.',
            'logo.image' => 'Berkas berkategori logo harus berupa format gambar.',
            'logo.max' => 'Ukuran berkas logo maksimal berkapasitas 2 Megabytes.',
        ];
    }
}