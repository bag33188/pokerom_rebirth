<?php

namespace App\Services\Api;

use App\Interfaces\Action\UserActionsInterface;
use App\Interfaces\Service\UserServiceInterface;
use App\Models\User;
use Symfony\Component\HttpFoundation\Response as HttpStatus;
use UserRepo;
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
        return new JsonDataResponse(['message' => "user $user->name deleted!"], HttpStatus::HTTP_OK);
    }

    public function registerUserToken(User $user): JsonDataResponse
    {
        $token = $this->userActions->generateUserApiToken($user);
        return new JsonDataResponse([
            'user' => $user,
            'token' => $token
        ], HttpStatus::HTTP_CREATED);
    }

    public function logoutCurrentUser(): JsonDataResponse
    {
        $this->userActions->revokeUserTokens();
        return new JsonDataResponse(['message' => 'logged out!'], HttpStatus::HTTP_OK);
    }

    public function authenticateUserAgainstCredentials(User $user, string $requestPassword): JsonDataResponse
    {
        // Check password hash against database
        if (!$user->checkPassword($requestPassword)) {
            return new JsonDataResponse(['message' => 'Bad credentials'], HttpStatus::HTTP_UNAUTHORIZED);
        }

        $token = $this->userActions->generateUserApiToken($user);
        return new JsonDataResponse([
            'user' => $user,
            'token' => $token
        ], HttpStatus::HTTP_OK);
    }

    public function retrieveUserBearerToken(): JsonDataResponse
    {
        if (request()->is("api/*")) {
            $token = UserRepo::getUserBearerToken();
            if (isset($token)) {
                return new JsonDataResponse(['token' => $token], HttpStatus::HTTP_OK);
            } else {
                return new JsonDataResponse(['message' => 'No token exists.'], HttpStatus::HTTP_NOT_FOUND);
            }
        } else {
            return new JsonDataResponse(
                ['message' => 'Cannot retrieve Bearer token on non-api request.'],
                HttpStatus::HTTP_BAD_REQUEST,
                ['X-Attempted-Request-Url' => request()->url()]
            );
        }

    }
}
