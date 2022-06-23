<?php

namespace App\Services;

use App\Interfaces\UserDataServiceInterface;
use App\Models\User;
use Symfony\Component\HttpFoundation\Response as ResponseAlias;
use Utils\Modules\JsonDataResponse;

class UserDataService implements UserDataServiceInterface
{
    private static function generateUserApiToken(User $user): string
    {
        return $user->createToken(API_TOKEN_KEY)->plainTextToken;
    }

    private function revokeUserTokens(): void
    {
        auth()->user()->tokens()->delete();
    }

    public function deleteUser(User $user): JsonDataResponse
    {
        $this->revokeUserTokens();
        $user->delete();
        return new JsonDataResponse(['message' => "user $user->name deleted!"], ResponseAlias::HTTP_OK);
    }

    public function registerUserToken(User $user): JsonDataResponse
    {
        $token = self::generateUserApiToken($user);
        return new JsonDataResponse([
            'user' => $user,
            'token' => $token
        ], ResponseAlias::HTTP_CREATED);
    }

    public function logoutCurrentUser(): JsonDataResponse
    {
        $this->revokeUserTokens();
        return new JsonDataResponse(['message' => 'logged out!'], ResponseAlias::HTTP_OK);
    }

    public function authenticateUserAgainstCredentials(User $user, string $requestPassword): JsonDataResponse
    {
        // Check password hash against database
        if (!$user->checkPassword($requestPassword)) {
            return new JsonDataResponse(['message' => 'Bad credentials'], ResponseAlias::HTTP_UNAUTHORIZED);
        }

        $token = self::generateUserApiToken($user);
        return new JsonDataResponse([
            'user' => $user,
            'token' => $token
        ], ResponseAlias::HTTP_OK);
    }
}
