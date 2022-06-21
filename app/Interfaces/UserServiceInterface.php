<?php

namespace App\Interfaces;

use App\Models\User;
use App\Services\JsonServiceResponse;

interface UserServiceInterface
{
    public function authenticateUserAgainstCredentials(User $user, string $requestPassword): JsonServiceResponse;

    public function logoutCurrentUser(): JsonServiceResponse;

    public function registerUserToken(User $user): JsonServiceResponse;

    public function deleteUser(User $user): JsonServiceResponse;
}
