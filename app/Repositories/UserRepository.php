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

    public function paginateUsers(): array|LengthAwarePaginator|_IH_User_C
    {
        return $this->user->paginate(4)->withQueryString();
    }

    public function getAllUsers(): Collection|array|_IH_User_C
    {
        return $this->user->all();
    }
}
