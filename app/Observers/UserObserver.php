<?php

namespace App\Observers;

use App\Events\UserDeleted;
use App\Events\UserRegistered;
use App\Models\User;


class UserObserver
{
    public bool $afterCommit = true;

    public function created(User $user): void
    {
        UserRegistered::dispatch($user);
    }

    public function deleted(User $user): void
    {
        UserDeleted::dispatchUnless($user->isAdmin(), $user);
    }
}
