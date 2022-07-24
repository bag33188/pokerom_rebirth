<?php

namespace App\Policies;

use App\Actions\User\AuthIdMatchesRequestedIDTrait as CompareUserIdAction;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class UserPolicy
{
    use HandlesAuthorization;
    use CompareUserIdAction {
        compare as protected compareUsers;
    }

    public function viewAny(User $user, User $model): bool
    {
        return $user->isAdmin();
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
        return $this->compareUsers($user, $model);
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
        return $this->compareUsers($user, $model);
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
        return $this->compareUsers($user, $model);
    }
}
