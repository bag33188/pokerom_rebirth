<?php

namespace App\Policies;

use App\Models\File;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class FilePolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can create models.
     *
     * @param User $user
     * @return bool
     */
    public function create(User $user): bool
    {
        return $user->isAdmin();
    }

    public function view(User $user, File $file): bool
    {
        return $user->isAdmin();
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param User $user
     * @param File $file
     * @return bool
     */
    public function delete(User $user, File $file): bool
    {
        return $user->isAdmin();
    }
}
