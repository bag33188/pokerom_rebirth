<?php

namespace App\Interfaces\Action;

use App\Models\User;

interface UserActionsInterface
{
    public function generateUserApiToken(User $user): string;

    public function revokeUserTokens(): void;

    public function makeUserAdministrator(User $user): bool;
}
