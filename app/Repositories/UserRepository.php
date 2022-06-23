<?php

namespace App\Repositories;

use App\Interfaces\UserRepositoryInterface;
use App\Models\User;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Pagination\LengthAwarePaginator;

class UserRepository implements UserRepositoryInterface
{
    public function findUserIfExists(int $userId): User
    {
        return User::findOrFail($userId);
    }

    public function findUserByEmail(string $email): User
    {
        return User::where('email', $email)->firstOrFail();
    }

    public function paginateUsers(?int $perPage = null): LengthAwarePaginator
    {
        return User::paginate($perPage ?? 4)->withQueryString();
    }

    public function getAllUsers(): Collection
    {
        return User::all();
    }
}
