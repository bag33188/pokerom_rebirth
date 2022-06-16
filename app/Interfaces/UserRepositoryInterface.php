<?php

namespace App\Interfaces;

interface UserRepositoryInterface
{
    public function getAllUsers();

    public function findUserIfExists(int $userId);

    public function paginateUsers(?int $perPage);
}
