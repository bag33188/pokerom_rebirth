<?php

namespace App\Interfaces\Service;

use App\Models\User;

interface UserServiceInterface
{
    public function generateUserPersonalAccessToken(User $user): string;

    public function revokeUserTokens(): int;

    public function makeUserAdministrator(User $user): bool;
}
