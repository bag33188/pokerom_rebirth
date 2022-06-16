<?php

namespace App\Services;

use App\Interfaces\UserServiceInterface;
use App\Models\User;
use JetBrains\PhpStorm\ArrayShape;
use Symfony\Component\HttpFoundation\Response as ResponseAlias;
use Symfony\Component\HttpKernel\Exception\UnauthorizedHttpException;

class UserService implements UserServiceInterface
{

    private function generateUserApiToken(User $user)
    {
        return $user->createToken(API_TOKEN_KEY)->plainTextToken;
    }

    private function deleteAllUserAccessTokens()
    {
        auth()->user()->tokens()->delete();
    }

    private function deleteUserCurrentAccessTokens()
    {
        auth()->user()->currentAccessToken()->delete();
    }

    #[ArrayShape(['message' => "string"])]
    public function deleteUserAndTokens(User $user): array
    {
        $this->deleteAllUserAccessTokens();
        $user->delete();
        return ['message' => "user $user->name deleted!"];
    }

    #[ArrayShape(['user' => "\App\Models\User", 'token' => "\Laravel\Sanctum\string|string"])]
    public function registerUserToken(User $user): array
    {
        $token = $this->generateUserApiToken($user);
        return [
            'user' => $user,
            'token' => $token
        ];
    }

    #[ArrayShape(['message' => "string"])]
    public function logoutCurrentUser(): array
    {
        $this->deleteUserCurrentAccessTokens();
        return ['message' => 'logged out!'];
    }

    #[ArrayShape(['user' => "\App\Models\User", 'token' => "\Laravel\Sanctum\string|string"])]
    public function authenticateUserAgainstCreds(User $user, string $requestPassword): array
    {
        // Check password hash against database
        if (!$user->checkPassword($requestPassword)) {
            throw new UnauthorizedHttpException(challenge: $requestPassword, message: 'Bad credentials', code: ResponseAlias::HTTP_UNAUTHORIZED);
        }

        $token = $this->generateUserApiToken($user);
        return [
            'user' => $user,
            'token' => $token
        ];
    }
}
