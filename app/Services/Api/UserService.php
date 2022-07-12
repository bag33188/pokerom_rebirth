<?php

namespace App\Services\Api;

use App\Interfaces\Action\UserActionsInterface;
use App\Interfaces\Service\UserServiceInterface;
use App\Models\User;
use Symfony\Component\HttpFoundation\Response as HttpResponse;
use Utils\Modules\JsonDataResponse;

class UserService implements UserServiceInterface
{
    public function __construct(private readonly UserActionsInterface $userActions)
    {
    }

    public function deleteUser(User $user): JsonDataResponse
    {
        $this->userActions->revokeUserTokens();
        $user->delete();
        return new JsonDataResponse(['message' => "user $user->name deleted!"], HttpResponse::HTTP_OK);
    }

    public function registerUserToken(User $user): JsonDataResponse
    {
        $token = $this->userActions->generateUserApiToken($user);
        return new JsonDataResponse([
            'user' => $user,
            'token' => $token
        ], HttpResponse::HTTP_CREATED);
    }

    public function logoutCurrentUser(): JsonDataResponse
    {
        $this->userActions->revokeUserTokens();
        return new JsonDataResponse(['message' => 'logged out!'], HttpResponse::HTTP_OK);
    }

    public function authenticateUserAgainstCredentials(User $user, string $requestPassword): JsonDataResponse
    {
        // Check password hash against database
        if (!$user->checkPassword($requestPassword)) {
            return new JsonDataResponse(['message' => 'Bad credentials'], HttpResponse::HTTP_UNAUTHORIZED);
        }

        $token = $this->userActions->generateUserApiToken($user);
        return new JsonDataResponse([
            'user' => $user,
            'token' => $token
        ], HttpResponse::HTTP_OK);
    }
}
