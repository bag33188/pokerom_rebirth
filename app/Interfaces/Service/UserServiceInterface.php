<?php

namespace App\Interfaces\Service;

use App\Models\User;
use Utils\Modules\JsonDataResponse;

interface UserServiceInterface
{
    public function authenticateUserAgainstCredentials(User $user, string $requestPassword): JsonDataResponse;

    public function logoutCurrentUser(): JsonDataResponse;

    public function registerUserToken(User $user): JsonDataResponse;

    public function deleteUser(User $user): JsonDataResponse;
}
