<?php

namespace App\Services\Objects;

use App\Interfaces\Service\UserServiceInterface;
use App\Models\User;
use App\Queries\UserQueriesTrait as UserQueries;
use Auth;

class UserService implements UserServiceInterface
{
    use UserQueries {
        updateUserSetAdminRole as private updateUserSetAdminRoleCommand;
    }

    public function generateUserPersonalAccessToken(User $user): string
    {
        return $user->createToken(API_TOKEN_KEY)->plainTextToken;
    }

    /**
     * @return int 1 if successful
     */
    public function revokeUserApiTokens(): int
    {
        return auth('api')->user()->tokens()->delete();
    }

    public function setLoginApiUser(User $user): void
    {
        Auth::guard('api')->login($user);
    }

    public function makeUserAdministrator(User $user): bool
    {
        if (auth()->user()->isAdmin()) {
            $this->updateUserSetAdminRoleCommand($user->getKey());
            $user->refresh();
            // check if user was successfully updated
            return $user->isAdmin();
        } else {
            return false;
        }
    }
}