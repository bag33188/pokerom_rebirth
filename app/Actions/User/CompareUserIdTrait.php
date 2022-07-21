<?php

namespace App\Actions\User;

use App\Models\User;

trait CompareUserIdTrait
{
    /**
     * Check if Current user's ID is equal to that of the User being authenticated.
     *
     * @param User $authUser auth instance user
     * @param User $requestUser request instance user
     * @return bool
     */
    public function requestInstanceUserIdIsAuthInstanceUserId(User $authUser, User $requestUser): bool
    {
        return
            (string)$authUser->getAttributeValue('id')
            ===
            (string)$requestUser->getAttributeValue('id');
    }
}
