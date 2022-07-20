<?php

namespace App\Interfaces\Service;

use App\Models\User;

interface UserServiceInterface
{
    public function generateUserPersonalAccessToken(User $user): string;

    public function revokeUserApiTokens(): int;

    public function makeUserAdministrator(User $user): bool;

    public function setLoginApiUser(User $user): void;
}
