<?php

namespace App\Services\Api;

use App\Interfaces\Service\UserServiceInterface;
use App\Models\User;
use App\Queries\UserQueriesTrait as UserQueries;

class UserService implements UserServiceInterface
{
    use UserQueries;

    public function generateUserApiToken(): string
    {
        // todo: make sure user is current request/auth user
        return User::createToken(API_TOKEN_KEY)->plainTextToken;
    }

    /**
     * @return int 1 if successful
     */
    public function revokeUserTokens(): int
    {
        return auth()->user()->tokens()->delete();
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
