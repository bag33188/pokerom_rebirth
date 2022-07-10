<?php

namespace App\Policies;

use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class UserPolicy
{
    use HandlesAuthorization;

    /**
     * Check if Current user's ID is equal to that of the User being authenticated.
     *
     * @param User $user
     * @param User $model
     * @return bool
     */
    private static function currentUserIdIsAuthUserId(User $user, User $model): bool
    {
        return $user->getAttributeValue('id') == $model->getAttributeValue('id');
    }

    /**
     * Determine whether the user can view the model.
     *
     * @param User $user
     * @param User $model
     * @return bool
     */
    public function view(User $user, User $model): bool
    {
        return self::currentUserIdIsAuthUserId($user, $model);
    }

    /**
     * Determine whether the user can update the model.
     *
     * @param User $user
     * @param User $model
     * @return bool
     */
    public function update(User $user, User $model): bool
    {
        return self::currentUserIdIsAuthUserId($user, $model);
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param User $user
     * @param User $model
     * @return bool
     */
    public function delete(User $user, User $model): bool
    {
        return self::currentUserIdIsAuthUserId($user, $model);
    }
}
