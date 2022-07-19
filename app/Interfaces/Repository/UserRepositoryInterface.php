<?php

namespace App\Interfaces\Repository;

use App\Models\User;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Pagination\LengthAwarePaginator;

interface UserRepositoryInterface
{
    public function getAllUsers(): Collection;

    public function findUserIfExists(int $userId): User;

    public function getPaginatedUsers(?int $perPage): array|LengthAwarePaginator;

    public function getPaginatedUsersWithQueryString(?int $perPage): array|LengthAwarePaginator;

    public function findUserByEmail(string $email): User;

    public function getUsersCount(): int;
}
