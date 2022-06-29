<?php

namespace App\Interfaces;

use App\Models\User;

interface UserActionsInterface
{
    public function generateUserApiToken(User $user): string;

    public function revokeUserTokens(): void;
}
