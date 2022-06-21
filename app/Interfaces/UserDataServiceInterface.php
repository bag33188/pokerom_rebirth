<?php

namespace App\Interfaces;

use App\Models\User;
use Utils\Classes\JsonDataServiceResponse;

interface UserDataServiceInterface
{
    public function authenticateUserAgainstCredentials(User $user, string $requestPassword): JsonDataServiceResponse;

    public function logoutCurrentUser(): JsonDataServiceResponse;

    public function registerUserToken(User $user): JsonDataServiceResponse;

    public function deleteUser(User $user): JsonDataServiceResponse;
}
