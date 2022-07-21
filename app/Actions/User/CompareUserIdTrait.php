<?php

namespace App\Actions\User;

use App\Models\User;
use App\Policies\UserPolicy;

trait CompareUserIdTrait
{
    /**
     * Check if Current user's ID is equal to that of the User being authenticated.
     *
     * Mainly for use in {@see UserPolicy} methods.
     *
     * @param User $authUser auth instance user
     * @param User $requestUser request instance user
     * @return bool
     */
    public function requestInstanceUserIdIsAuthInstanceUserId(User $authUser, User $requestUser): bool
    {
        $_key_id = 'id';
        return
            (string)$authUser->getAttributeValue($_key_id)
            ===
            (string)$requestUser->getAttributeValue($_key_id);
    }
}
