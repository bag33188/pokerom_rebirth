<?php

namespace App\Actions;

use App\Interfaces\Action\UserActionsInterface;
use App\Models\User;
use App\Queries\UserQueriesTrait as UserQueries;

class UserActions implements UserActionsInterface
{
    use UserQueries;

    public function generateUserApiToken(User $user): string
    {
        return $user->createToken(API_TOKEN_KEY)->plainTextToken;
    }

    public function revokeUserTokens(): void
    {
        auth()->user()->tokens()->delete();
    }

    public function getUserBearerToken(): ?string
    {
        return request()->bearerToken();
    }

    public function makeUserAdministrator(User $user): bool
    {
        if (auth()->user()->isAdmin()) {
            $this->updateUserSetAdminRole($user->getKey());
            $user->refresh();
            // check if user was successfully updated
            return $user->isAdmin();
        } else {
            return false;
        }
    }
}
