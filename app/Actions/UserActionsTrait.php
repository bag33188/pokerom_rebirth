<?php

namespace App\Actions;

use App\Models\User;
use Illuminate\Support\Facades\Auth;

trait UserActionsTrait
{
    public function authIdIsRequestedUserId(User $currentUser, User $requestedUser): bool
    {
        return
            (string)$currentUser->getAttributeValue('id')
            ===
            (string)$requestedUser->getAttributeValue('id');
    }

    public function showCurrentAuthGuard(): void
    {
        print Auth::getDefaultDriver();
    }
}
