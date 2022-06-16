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
        if ($request->query('paginate') === 'true') {
            return response()->json($this->userRepository->paginateUsers());
        } else {
            return new UserCollection($this->userRepository->getAllUsers());
        }
    }

    public function register(StoreUserRequest $request): JsonResponse
    {
        $user = User::create($request->all());
        return response()->json($this->userService->registerUserToken($user), ResponseAlias::HTTP_CREATED);
    }

    public function login(LoginRequest $request): JsonResponse
    {
        // Check email
        $user = User::where('email', $request['email'])->firstOrFail();
        return response()->json($this->userService->authenticateUserAgainstCredentials($user, $request['password']));
    }

    public function logout(): JsonResponse
    {
        return response()->json($this->userService->logoutCurrentUser());
    }


    /**
     * @throws AuthorizationException
     */
    public function show(int $id): UserResource
    {
        $user = User::findOrFail($id);
        $this->authorize('view', $user);
        return new UserResource($user);
    }

    public function showMe(Request $request)
    {
        return response()->json($request->user());
    }

    /**
     * unfinished
     * @throws AuthorizationException
     */
    public function update(Request $request, int $userId)
    {
        $user = $request->user(); // User::find($userId);
        $this->authorize('update', $user);
        $user->update(['password' => $request['password']]);
        return response($user);
    }

    /**
     * @throws AuthorizationException
     */
    public function destroy(int $userId)
    {
        $user = User::findOrFail($userId);
        $this->authorize('delete', $user);

        return response()->json($this->userService->deleteUserAndTokens($user));
    }
}
