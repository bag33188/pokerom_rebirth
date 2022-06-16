<?php

namespace App\Repositories;

use App\Interfaces\UserRepositoryInterface;
use App\Models\User;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Pagination\LengthAwarePaginator;
use LaravelIdea\Helper\App\Models\_IH_User_C;

class UserRepository implements UserRepositoryInterface
{
    private User $user;

    public function __construct(User $user)
    {
        $this->user = $user;
    }

    public function findUserIfExists(int $userId): array|User|_IH_User_C
    {
        return $this->user->findOrFail($userId);
    }

    public function paginateUsers(int $perPage = 4): array|LengthAwarePaginator|_IH_User_C
    {
        return $this->user->paginate($perPage)->withQueryString();
    }

    public function getAllUsers(): Collection|array|_IH_User_C
    {
        return $this->user->all();
    }
}
