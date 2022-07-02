<?php

namespace App\Actions;

use App\Interfaces\Action\UserActionsInterface;
use App\Models\User;

class UserActions implements UserActionsInterface
{
    public function generateUserApiToken(User $user): string
    {
        return $user->createToken(API_TOKEN_KEY)->plainTextToken;
    }

    public function revokeUserTokens(): void
    {
        auth()->user()->tokens()->delete();
    }
}
