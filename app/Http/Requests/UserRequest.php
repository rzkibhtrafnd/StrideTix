<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rules\Enum;
use App\Enums\UserRole;

class UserRequest extends FormRequest
{
    public function authorize(): bool
    {
        return Auth::user()?->role === UserRole::ADMIN;
    }

    public function rules(): array
    {
        $rules = [
            'name' => 'required|string|max:255',
            'role' => ['required', new Enum(UserRole::class)],
        ];

        $userId = optional($this->route('user'))->id ?? $this->route('user');

        if ($this->isMethod('POST')) {
            $rules['email']    = 'required|string|email|max:255|unique:users,email';
            $rules['phone']    = 'required|string|max:20|unique:users,phone';
            $rules['password'] = 'required|string|min:8|confirmed';
        } else {
            $rules['email']    = 'required|string|email|max:255|unique:users,email,' . $userId;
            $rules['phone']    = 'required|string|max:20|unique:users,phone,' . $userId;
            $rules['password'] = 'nullable|string|min:8|confirmed';
        }

        return $rules;
    }

    public function messages(): array
    {
        return [
            'name.required' => 'Nama lengkap wajib diisi.',
            'role.required' => 'Hak akses (role) wajib dipilih.',
            'role.in' => 'Pilihan hak akses tidak valid.',
            'email.required' => 'Alamat email wajib diisi.',
            'email.email' => 'Format alamat email tidak valid.',
            'email.unique' => 'Alamat email ini sudah terdaftar di sistem.',
            'phone.required' => 'Nomor telepon wajib diisi.',
            'phone.unique' => 'Nomor telepon ini sudah terdaftar di sistem.',
            'password.required' => 'Password wajib diisi.',
            'password.min' => 'Password minimal harus terdiri dari 8 karakter.',
            'password.confirmed' => 'Konfirmasi password tidak cocok.',
        ];
    }
}