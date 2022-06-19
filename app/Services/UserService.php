<?php

namespace App\Services;

use App\Interfaces\UserServiceInterface;
use App\Models\User;
use JetBrains\PhpStorm\ArrayShape;
use Symfony\Component\HttpFoundation\Response as ResponseAlias;
use Symfony\Component\HttpKernel\Exception\UnauthorizedHttpException;

class UserService implements UserServiceInterface
{
    private static function generateUserApiToken(User $user): string
    {
        return $user->createToken(API_TOKEN_KEY)->plainTextToken;
    }

    private static function revokeAllUserTokens()
    {
        auth()->user()->tokens()->delete();
    }

    #[ArrayShape(['message' => "string"])]
    public function deleteUser(User $user): array
    {
        self::revokeAllUserTokens();
        $user->delete();
        return ['message' => "user $user->name deleted!"];
    }

    #[ArrayShape(['user' => "\App\Models\User", 'token' => "\Laravel\Sanctum\string|string"])]
    public function registerUserToken(User $user): array
    {
        $token = self::generateUserApiToken($user);
        return [
            'user' => $user,
            'token' => $token
        ];
    }

    #[ArrayShape(['message' => "string"])]
    public function logoutCurrentUser(): array
    {
        self::revokeAllUserTokens();
        return ['message' => 'logged out!'];
    }

    #[ArrayShape(['user' => "\App\Models\User", 'token' => "\Laravel\Sanctum\string|string"])]
    public function authenticateUserAgainstCredentials(User $user, string $requestPassword): array
    {
        // Check password hash against database
        if (!$user->checkPassword($requestPassword)) {
            throw new UnauthorizedHttpException(
                challenge: $requestPassword,
                message: 'Bad credentials',
                code: ResponseAlias::HTTP_UNAUTHORIZED);
        }

        $token = self::generateUserApiToken($user);
        return [
            'user' => $user,
            'token' => $token
        ];
    }
}
