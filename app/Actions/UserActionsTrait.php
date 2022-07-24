<?php

namespace App\Actions;

use App\Models\User;
use Illuminate\Support\Facades\Auth;

trait UserActionsTrait
{
    public function authIdIsRequestedUserId(User $currentUser, User $requestedUser): bool
    {
        $_user_key_id_ = 'id';
        return
            (string)$currentUser->getAttributeValue($_user_key_id_)
            ===
            (string)$requestedUser->getAttributeValue($_user_key_id_);
    }

    public function getCurrentAuthGuard(): void
    {
        print Auth::getDefaultDriver();
    }
}
