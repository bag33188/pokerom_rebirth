<?php

namespace App\Interfaces\Service;

use App\Models\User;

interface UserServiceInterface
{
    public function generatePersonalAccessToken(User $user): string;

    public function revokeApiTokens(): bool;

    public function makeAdministrator(User $user): bool;
}
