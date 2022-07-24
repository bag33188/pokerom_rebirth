<?php

namespace App\Actions\User;

use App\Models\User;
use App\Policies\UserPolicy;

trait AuthIdMatchesRequestedId
{
    /**
     * Check if Current user's ID is equal to that of the User being authenticated.
     *
     * Mainly for use in {@see UserPolicy} methods.
     *
     * @param User $currentUser auth instance user
     * @param User $requestedUser requested user object
     * @return bool
     */
    public function compare(User $currentUser, User $requestedUser): bool
    {
        $_user_key_id_ = 'id';
        return
            (string)$currentUser->getAttributeValue($_user_key_id_)
            ===
            (string)$requestedUser->getAttributeValue($_user_key_id_);
    }
}
