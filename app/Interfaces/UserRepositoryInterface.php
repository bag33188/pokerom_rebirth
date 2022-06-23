<?php

namespace App\Interfaces;

use App\Models\User;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Pagination\LengthAwarePaginator;

interface UserRepositoryInterface
{
    public function getAllUsers(): Collection;

    public function findUserIfExists(int $userId): User;

    public function paginateUsers(?int $perPage): LengthAwarePaginator;

    public function findUserByEmail(string $email): User;
}
