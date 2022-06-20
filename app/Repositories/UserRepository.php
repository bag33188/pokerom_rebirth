<?php

namespace App\Repositories;

use App\Interfaces\UserRepositoryInterface;
use App\Models\User;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Pagination\LengthAwarePaginator;

class UserRepository implements UserRepositoryInterface
{
    private User $user;

    public function __construct(User $user)
    {
        $this->user = $user;
    }

    public function findUserIfExists(int $userId): User
    {
        return $this->user->findOrFail($userId);
    }

    public function paginateUsers(?int $perPage = null): LengthAwarePaginator
    {
        return $this->user->paginate($perPage ?: 4)->withQueryString();
    }

    public function getAllUsers(): Collection
    {
        return $this->user->all();
    }
}
