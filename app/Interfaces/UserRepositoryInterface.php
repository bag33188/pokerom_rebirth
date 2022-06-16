<?php

namespace App\Interfaces;

interface UserRepositoryInterface
{
    public function getAllUsers();

    public function paginateUsers();
}
