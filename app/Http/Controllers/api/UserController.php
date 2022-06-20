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
use Symfony\Component\HttpFoundation\Response as ResponseAlias;

class UserController extends ApiController
{
    private UserServiceInterface $userService;
    private UserRepositoryInterface $userRepository;

    public function __construct(UserServiceInterface $userService, UserRepositoryInterface $userRepository)
    {
        $this->userService = $userService;
        $this->userRepository = $userRepository;
    }

    /**
     * @throws AuthorizationException
     */
    public function index(Request $request): JsonResponse|UserCollection
    {
        Gate::authorize('viewAny-user');
        if (filter_var($request->query('paginate'), FILTER_VALIDATE_BOOLEAN) === true) {
            return response()
                ->json($this->userRepository->paginateUsers((int)$request->query('per_page')),
                    ResponseAlias::HTTP_OK);
        } else {
            return new UserCollection($this->userRepository->getAllUsers());
        }
    }

    public function register(StoreUserRequest $request): JsonResponse
    {
        $user = User::create($request->all());
        $res = $this->userService->registerUserToken($user);
        return response()->json($res->json, $res->code);
    }

    public function login(LoginRequest $request): JsonResponse
    {
        $user = $this->userRepository->findUserByEmail($request['email']);
        $res = $this->userService->authenticateUserAgainstCredentials($user, $request['password']);
        return response()->json($res->json, $res->code);
    }

    public function logout(): JsonResponse
    {
        $res = $this->userService->logoutCurrentUser();
        return response()->json($res->json, $res->code);
    }


    /**
     * @throws AuthorizationException
     */
    public function show(int $userId): UserResource
    {
        $user = $this->userRepository->findUserIfExists($userId);
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
        $user = $this->userRepository->findUserIfExists($userId);
        $this->authorize('delete', $user);
        $res = $this->userService->deleteUser($user);
        return response()->json($res->json, $res->code);
    }
}
