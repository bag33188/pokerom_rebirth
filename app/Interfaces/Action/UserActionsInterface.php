<?php

namespace App\Interfaces\Action;

use App\Models\User;

interface UserActionsInterface
{
    public function generateUserApiToken(User $user): string;

    public function revokeUserTokens(): int;

    public function makeUserAdministrator(User $user): bool;
}
