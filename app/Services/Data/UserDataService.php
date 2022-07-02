<?php

namespace App\Services\Data;

use App\Interfaces\Action\UserActionsInterface;
use App\Interfaces\Service\UserDataServiceInterface;
use App\Models\User;
use Symfony\Component\HttpFoundation\Response as ResponseAlias;
use Utils\Modules\JsonDataResponse;

class UserDataService implements UserDataServiceInterface
{
    private UserActionsInterface $userActions;

    public function __construct(UserActionsInterface $userActions)
    {
        $this->userActions = $userActions;
    }

    public function deleteUser(User $user): JsonDataResponse
    {
        $this->userActions->revokeUserTokens();
        $user->delete();
        return new JsonDataResponse(['message' => "user $user->name deleted!"], ResponseAlias::HTTP_OK);
    }

    public function registerUserToken(User $user): JsonDataResponse
    {
        $token = $this->userActions->generateUserApiToken($user);
        return new JsonDataResponse([
            'user' => $user,
            'token' => $token
        ], ResponseAlias::HTTP_CREATED);
    }

    public function logoutCurrentUser(): JsonDataResponse
    {
        $this->userActions->revokeUserTokens();
        return new JsonDataResponse(['message' => 'logged out!'], ResponseAlias::HTTP_OK);
    }

    public function authenticateUserAgainstCredentials(User $user, string $requestPassword): JsonDataResponse
    {
        // Check password hash against database
        if (!$user->checkPassword($requestPassword)) {
            return new JsonDataResponse(['message' => 'Bad credentials'], ResponseAlias::HTTP_UNAUTHORIZED);
        }

        $token = $this->userActions->generateUserApiToken($user);
        return new JsonDataResponse([
            'user' => $user,
            'token' => $token
        ], ResponseAlias::HTTP_OK);
    }
}
