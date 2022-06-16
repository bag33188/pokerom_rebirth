<?php

namespace App\Interfaces;

use App\Models\User;

interface UserRepositoryInterface
{
    public function deleteUserAndTokens(User $user);

    public function registerUserToken(User $user);

    public function logoutCurrentUser(User $user);
    public function authenticateUserAgainstCreds(User $user, string $requestPassword);
}
