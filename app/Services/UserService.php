<?php

namespace App\Services;

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Pagination\LengthAwarePaginator;

class UserService
{
    public function getAllUsers(int $perPage = 10): LengthAwarePaginator
    {
        return User::latest()->paginate($perPage);
    }

    public function createUser(array $data): User
    {
        $data['password'] = Hash::make($data['password']);
        return User::create($data);
    }

    public function updateUser(User $user, array $data): bool
    {
        if (!empty($data['password'])) {
            $data['password'] = Hash::make($data['password']);
        } else {
            unset($data['password']);
        }

        return $user->update($data);
    }

    public function deleteUser(User $user): bool
    {
        if ($user->id === Auth::id()) {
            return false;
        }
        return $user->delete();
    }
}