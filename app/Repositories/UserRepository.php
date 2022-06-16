<?php

namespace App\Repositories;

use App\Interfaces\UserRepositoryInterface;
use App\Models\User;
use JetBrains\PhpStorm\ArrayShape;

class UserRepository implements UserRepositoryInterface
{
    #[ArrayShape(['message' => "string"])]
    public function deleteUserAndTokens(User $user): array
    {
        auth()->user()->tokens()->delete();
        $user->delete();
        return ['message' => "user $user->name deleted!"];
    }

    #[ArrayShape(['user' => "\App\Models\User", 'token' => "\Laravel\Sanctum\string|string"])]
    public function registerUserToken(User $user): array
    {
        $token = $user->createToken('auth_token')->plainTextToken;
        return [
            'user' => $user,
            'token' => $token
        ];
    }

    #[ArrayShape(['message' => "string"])]
    public function logoutCurrentUser(User $user): array
    {
        auth()->user()->currentAccessToken()->delete();
        return ['message' => 'logged out!'];
    }
}
