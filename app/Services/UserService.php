<?php

namespace App\Services;

use App\Models\User;
use JetBrains\PhpStorm\ArrayShape;
use Symfony\Component\HttpFoundation\Response as ResponseAlias;
use Symfony\Component\HttpKernel\Exception\UnauthorizedHttpException;

class UserService
{
    private User $user;
    public function __construct(User $user)
    {
        $this->user=$user;
    }

    private function generateUserApiToken(): string|\Laravel\Sanctum\string
    {
        return $this->user->createToken(API_TOKEN_KEY)->plainTextToken;
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
    public function deleteUserAndTokens(): array
    {
        $this->deleteAllUserAccessTokens();
        $this->user->delete();
        return ['message' => "user $this->user->name deleted!"];
    }

    #[ArrayShape(['user' => "\App\Models\User", 'token' => "\Laravel\Sanctum\string|string"])]
    public function registerUserToken(): array
    {
        $token = $this->generateUserApiToken();
        return [
            'user' => $this->user,
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
    public function authenticateUserAgainstCreds(string $requestPassword): array
    {
        // Check password hash against database
        if (!$this->user->checkPassword($requestPassword)) {
            throw new UnauthorizedHttpException(challenge: $requestPassword, message: 'Bad credentials', code: ResponseAlias::HTTP_UNAUTHORIZED);
        }

        $token = $this->generateUserApiToken();
        return [
            'user' => $this->user,
            'token' => $token
        ];
    }
}
