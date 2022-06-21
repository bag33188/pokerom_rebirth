<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller as ApiController;
use App\Http\Requests\LoginRequest;
use App\Http\Requests\StoreUserRequest;
use App\Http\Resources\UserCollection;
use App\Http\Resources\UserResource;
use App\Interfaces\UserRepositoryInterface;
use App\Interfaces\UserServiceInterface;
use App\Models\User;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use UserRepo;

class UserController extends ApiController
{
    private UserServiceInterface $userDataService;

    public function __construct(UserServiceInterface $userDataService, UserRepositoryInterface $userRepository)
    {
        $this->userDataService = $userDataService;
    }

    /**
     * @throws AuthorizationException
     */
    public function index(Request $request): JsonResponse|UserCollection
    {
        Gate::authorize('viewAny-user');
        if (filter_var($request->query('paginate'), FILTER_VALIDATE_BOOLEAN) === true) {
            return response()
                ->json(UserRepo::paginateUsers((int)$request->query('per_page')));
        } else {
            return new UserCollection(UserRepo::getAllUsers());
        }
    }

    public function register(StoreUserRequest $request): JsonResponse
    {
        $user = User::create($request->all());
        return $this->userDataService->registerUserToken($user)->response();
    }

    public function login(LoginRequest $request): JsonResponse
    {
        $user = UserRepo::findUserByEmail($request['email']);
        return $this->userDataService->authenticateUserAgainstCredentials($user, $request['password'])->response();
    }

    public function logout(): JsonResponse
    {
        return $this->userDataService->logoutCurrentUser()->response();
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

    public function showMe(Request $request)
    {
        return response()->json($request->user());
    }

    /**
     * @throws AuthorizationException
     */
    public function destroy(int $userId)
    {
        $user = UserRepo::findUserIfExists($userId);
        $this->authorize('delete', $user);
        return $this->userDataService->deleteUser($user)->response();
    }
}
