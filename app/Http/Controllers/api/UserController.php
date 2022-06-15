<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller as ApiController;
use App\Http\Requests\LoginRequest;
use App\Http\Requests\StoreUserRequest;
use App\Http\Resources\UserCollection;
use App\Http\Resources\UserResource;
use App\Models\User;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

class UserController extends ApiController
{
    public function index(Request $request): JsonResponse|UserCollection
    {
        Gate::authorize('viewAny-user');
        if ($request->query('paginate') === 'true') {
            return response()->json(User::paginate(4)->withQueryString());
        } else {
            return new UserCollection(User::all());
        }
    }

    public function register(StoreUserRequest $request): JsonResponse
    {
        $user = User::create($request->all());

        $token = $user->createToken('auth_token')->plainTextToken;

        $response = [
            'user' => $user,
            'token' => $token
        ];

        return response()->json($response, 201);
    }

    public function login(LoginRequest $request): JsonResponse
    {
        // Check email
        $user = User::where('email', $request['email'])->firstOrFail();

        // Check password
        if (!$user->checkPassword($request['password'])) {
            return response()->json([
                'message' => 'Bad credentials'
            ], 401);
        }

        $token = $user->createToken('auth_token')->plainTextToken;
        return response()->json([
            'user' => $user,
            'token' => $token
        ]);
    }

    public function logout(Request $request): JsonResponse
    {
        if ($request->user()) {
            auth()->user()->currentAccessToken()->delete();
        }
        return response()->json(['message' => 'logged out!']);
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
        auth()->user()->tokens()->delete();
        $user->delete();
        return response()->json(['message' => "user {$user->name} deleted!"]);
    }
}
