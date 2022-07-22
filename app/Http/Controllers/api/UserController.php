<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller as ApiController;
use App\Http\Requests\LoginRequest;
use App\Http\Requests\StoreUserRequest;
use App\Http\Requests\UpdateUserRequest;
use App\Http\Resources\UserCollection;
use App\Http\Resources\UserResource;
use App\Interfaces\Service\UserServiceInterface;
use App\Models\User;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response as HttpStatus;
use UserRepo;

class UserController extends ApiController
{
    /** @var string[] */
    private static array $queryParamNames = ['paginate', 'per_page'];

    public function __construct(private readonly UserServiceInterface $userService)
    {
    }

    /**
     * @param Request $request
     * @return UserCollection
     * @throws AuthorizationException
     */
    public function index(Request $request): UserCollection
    {
        $this->authorize('viewAny', $request->user());

        $paginate = $request->query(self::$queryParamNames[0]);
        $perPage = intval($request->query(self::$queryParamNames[1]));

        $paginateQueryIsTruthy = str_to_bool($paginate) === true;
        return $paginateQueryIsTruthy
            ? new UserCollection(UserRepo::getPaginatedUsers($perPage))
            : new UserCollection(UserRepo::getAllUsers());
    }

    public function register(StoreUserRequest $request): JsonResponse
    {
        $user = User::create($request->all());
        $token = $this->userService->generateUserPersonalAccessToken($user);
        return response()->json([
            'user' => $user,
            'token' => $token,
            'success' => true,
        ], HttpStatus::HTTP_CREATED);
    }

    public function login(LoginRequest $request): JsonResponse
    {
        $user = UserRepo::findUserByEmail($request['email']);
        $user->deleteExistingTokens();
        if ($user->checkPassword($request['password']) === true) {
            $token = $this->userService->generateUserPersonalAccessToken($user);
            $this->userService->setLoginApiUser($user);
            return response()->json([
                'user' => $user,
                'token' => $token,
                'success' => true,
            ], HttpStatus::HTTP_OK);
        } else {
            return response()->json([
                'message' => 'Bad credentials', 'success' => false
            ], HttpStatus::HTTP_UNAUTHORIZED);
        }
    }

    public function logout(): JsonResponse
    {
        $this->userService->revokeUserApiTokens();
        return response()->json([
            'message' => 'logged out!', 'success' => true
        ], HttpStatus::HTTP_OK);
    }

    public function update(UpdateUserRequest $request, int $userId): UserResource
    {
        $user = UserRepo::findUserIfExists($userId);
        $user->update($request->all());
        return new UserResource($user);
    }

    /**
     * @throws AuthorizationException
     */
    public function show(int $userId): UserResource
    {
        $user = UserRepo::findUserIfExists($userId);
        $this->authorize('view', $user);
        return new UserResource($user);
    }

    /**
     * @throws AuthorizationException
     */
    public function showMe(Request $request): JsonResponse
    {
        $user = $request->user();
        $this->authorize('view', $user);
        return response()->json(['data' => $user, 'success' => true]);
    }

    public function getCurrentUserBearerToken(): JsonResponse
    {
        $token = UserRepo::getUserBearerToken();
        return isset($token) ? response()->json([
            'token' => $token, 'success' => true,
        ], HttpStatus::HTTP_OK) : response()->json([
            'message' => 'No token exists.', 'success' => false,
        ], HttpStatus::HTTP_NOT_FOUND);
    }

    /**
     * @throws AuthorizationException
     */
    public function destroy(int $userId): JsonResponse
    {
        $user = UserRepo::findUserIfExists($userId);
        $this->authorize('delete', $user);
        $this->userService->revokeUserApiTokens();
        $user->delete();
        return response()->json([
            'message' => "user $user->name deleted!", 'success' => true,
        ], HttpStatus::HTTP_OK);
    }
}
