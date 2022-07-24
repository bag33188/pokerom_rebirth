<?php

namespace App\Services\Objects;

use App\Interfaces\Service\UserServiceInterface;
use App\Models\User;
use App\Queries\UserQueriesTrait as UserQueries;
use Auth;
use Request;

class UserService implements UserServiceInterface
{
    use UserQueries {
        updateUserSetAdminRole as private;
    }

    public function generatePersonalAccessToken(User $user): string
    {
        return $user->createToken(API_TOKEN_KEY)->plainTextToken;
    }

    public function revokeApiTokens(): bool
    {
        $authUser = Auth::user();
        if (Request::is('api/*') && isset($authUser)) {
            $authUser->deleteExistingApiTokens();
            return true;
        }
        return false;
    }

    public function makeAdministrator(User $user): bool
    {
        if (auth()->user()->isAdmin()) {
            $dbCommand = $this->updateUserSetAdminRole($user->getKey());
            // if command executes to truthy then refresh user resource instance
            if ($dbCommand) $user->refresh();
            // check if user was successfully updated
            return $user->isAdmin();
        } else {
            return false;
        }
    }
}
