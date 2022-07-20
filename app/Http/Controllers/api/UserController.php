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
        $token = $this->userService->generateUserApiToken();
        return response()->json([
            'user' => $user,
            'token' => $token,
            'success' => true,
        ], HttpStatus::HTTP_CREATED);
    }

    public function login(LoginRequest $request): JsonResponse
    {
        $user = UserRepo::findUserByEmail($request['email']);
        if ($user->checkPassword($request['password']) === true) {
            $token = $this->userService->generateUserApiToken();
            return response()->json([
                'user' => $user,
                'token' => $token,
                'success' => true,

            ], HttpStatus::HTTP_OK);
        } else {
            return response()->json(['message' => 'Bad credentials'], HttpStatus::HTTP_UNAUTHORIZED);
        }


    }

    public function logout(): JsonResponse
    {
        $this->userService->revokeUserTokens();
        return response()->json(['message' => 'logged out!', 'success' => true,
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

    public function showMe(): JsonResponse
    {
        return response()->json(['data' => request()->user()]);
    }

    public function getCurrentUserBearerToken(): JsonResponse
    {
        if (request()->is("api/*")) {
            $token = UserRepo::getUserBearerToken();
            if (isset($token)) {
                return response()->json(['token' => $token, 'success' => true,
                ], HttpStatus::HTTP_OK);
            } else {
                return response()->json(['message' => 'No token exists.', 'success' => false,
                ], HttpStatus::HTTP_NOT_FOUND);
            }
        } else {
            return response()->json(
                ['message' => 'Cannot retrieve Bearer token on non-api request.', 'success' => false,
                ],
                HttpStatus::HTTP_BAD_REQUEST,
                ['X-Attempted-Request-Url' => request()->url()]
            );
        }
    }

    /**
     * @throws AuthorizationException
     */
    public function destroy(int $userId): JsonResponse
    {
        $user = UserRepo::findUserIfExists($userId);
        $this->authorize('delete', $user);
        $this->userService->revokeUserTokens();
        $user->delete();
        return response()->json(['message' => "user $user->name deleted!", 'success' => true,
        ], HttpStatus::HTTP_OK);
    }
}
