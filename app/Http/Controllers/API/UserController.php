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
use Illuminate\Support\Facades\Gate;
use Symfony\Component\HttpFoundation\Response as HttpResponse;
use UserRepo;

class UserController extends ApiController
{
    /** @var string[] */
    private static array $queryParamNames = ['paginate', 'per_page'];

    public function __construct(private readonly UserServiceInterface $userService)
    {
    }

    /**
     * @throws AuthorizationException
     */
    public function index(Request $request): UserCollection
    {
        Gate::authorize('viewAny-user');

        $paginate = $request->query(self::$queryParamNames[0]);
        $perPage = (int)$request->query(self::$queryParamNames[1]);

        $paginateQueryIsTruthy = str_to_bool($paginate) === true;
        return $paginateQueryIsTruthy
            ? new UserCollection(UserRepo::getPaginatedUsers($perPage))
            : new UserCollection(UserRepo::getAllUsers());
    }

    public function register(StoreUserRequest $request): JsonResponse
    {
        $user = User::create($request->all());
        return $this->userService->registerUserToken($user)->renderResponse();
    }

    public function login(LoginRequest $request): JsonResponse
    {
        $user = UserRepo::findUserByEmail($request['email']);
        return $this->userService->authenticateUserAgainstCredentials($user, $request['password'])->renderResponse();
    }

    public function logout(): JsonResponse
    {
        return $this->userService->logoutCurrentUser()->renderResponse();
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

    public function showMe(): JsonResponse
    {
        return jsonData(['data' => request()->user()], HttpResponse::HTTP_OK);
    }

    public function getCurrentUserBearerToken(): JsonResponse
    {
        return $this->userService->retrieveUserBearerToken()->renderResponse();
    }

    /**
     * @throws AuthorizationException
     */
    public function destroy(int $userId): JsonResponse
    {
        $user = UserRepo::findUserIfExists($userId);
        $this->authorize('delete', $user);
        return $this->userService->deleteUser($user)->renderResponse();
    }
}
