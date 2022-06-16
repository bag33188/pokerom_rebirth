<?php

namespace App\Interfaces;

use App\Models\User;

interface UserServiceInterface {
    public function authenticateUserAgainstCreds(User $user, string $requestPassword);
    public function logoutCurrentUser();
    public function registerUserToken(User $user);
    public function deleteUserAndTokens(User $user);
}
