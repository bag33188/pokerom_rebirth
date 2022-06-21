<?php

namespace App\Services;

use App\Interfaces\UserServiceInterface;
use App\Models\User;
use Classes\JsonDataServiceResponse;
use Symfony\Component\HttpFoundation\Response as ResponseAlias;

class UserDataService implements UserServiceInterface
{
    private static function generateUserApiToken(User $user): string
    {
        return $user->createToken(API_TOKEN_KEY)->plainTextToken;
    }

    private function revokeUserTokens(): void
    {
        auth()->user()->tokens()->delete();
    }

    public function deleteUser(User $user): JsonDataServiceResponse
    {
        $this->revokeUserTokens();
        $user->delete();
        return new JsonDataServiceResponse(['message' => "user $user->name deleted!"], ResponseAlias::HTTP_OK);
    }

    public function registerUserToken(User $user): JsonDataServiceResponse
    {
        $token = self::generateUserApiToken($user);
        return new JsonDataServiceResponse([
            'user' => $user,
            'token' => $token
        ], ResponseAlias::HTTP_CREATED);
    }

    public function logoutCurrentUser(): JsonDataServiceResponse
    {
        $this->revokeUserTokens();
        return new JsonDataServiceResponse(['message' => 'logged out!'], ResponseAlias::HTTP_OK);
    }

    public function authenticateUserAgainstCredentials(User $user, string $requestPassword): JsonDataServiceResponse
    {
        // Check password hash against database
        if (!$user->checkPassword($requestPassword)) {
            return new JsonDataServiceResponse(['message' => 'Bad credentials'], ResponseAlias::HTTP_UNAUTHORIZED);
        }

        $token = self::generateUserApiToken($user);
        return new JsonDataServiceResponse([
            'user' => $user,
            'token' => $token
        ], ResponseAlias::HTTP_OK);
    }
}
