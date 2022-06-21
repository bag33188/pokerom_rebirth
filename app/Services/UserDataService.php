<?php

namespace App\Services;

use App\Interfaces\UserServiceInterface;
use App\Models\User;
use JetBrains\PhpStorm\ArrayShape;
use Symfony\Component\HttpFoundation\Response as ResponseAlias;

class UserDataService implements UserServiceInterface
{
    private static function generateUserApiToken(User $user): string
    {
        return $user->createToken(API_TOKEN_KEY)->plainTextToken;
    }

    private function revokeUserTokens()
    {
        auth()->user()->tokens()->delete();
    }

    public function deleteUser(User $user): JsonServiceResponse
    {
        $this->revokeUserTokens();
        $user->delete();
        return new JsonServiceResponse(['message' => "user $user->name deleted!"], ResponseAlias::HTTP_OK);
    }

    public function registerUserToken(User $user): JsonServiceResponse
    {
        $token = self::generateUserApiToken($user);
        return new JsonServiceResponse([
            'user' => $user,
            'token' => $token
        ], ResponseAlias::HTTP_CREATED);
    }

    public function logoutCurrentUser(): JsonServiceResponse
    {
        $this->revokeUserTokens();
        return new JsonServiceResponse(['message' => 'logged out!'], ResponseAlias::HTTP_OK);
    }

    public function authenticateUserAgainstCredentials(User $user, string $requestPassword): JsonServiceResponse
    {
        // Check password hash against database
        if (!$user->checkPassword($requestPassword)) {
            return new JsonServiceResponse(['message' => 'Bad credentials'], ResponseAlias::HTTP_UNAUTHORIZED);
        }

        $token = self::generateUserApiToken($user);
        return new JsonServiceResponse([
            'user' => $user,
            'token' => $token
        ], ResponseAlias::HTTP_OK);
    }
}
