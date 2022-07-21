<?php

namespace App\Observers;

use App\Events\UserDeleting;
use App\Events\UserRegistered;
use App\Interfaces\Service\UserServiceInterface;
use App\Models\User;

class UserObserver
{
    /**
     * Handle events after all transactions are committed.
     *
     * @var bool
     */
    public bool $afterCommit = true;

    public function __construct(private readonly UserServiceInterface $userService)
    {
    }

    public function created(User $user): void
    {
        UserRegistered::dispatch($user);
    }

    public function updated(User $user): void
    {
        $this->userService->revokeUserApiTokens();
    }

    public function deleting(User $user): void
    {
        UserDeleting::dispatchUnless($user->isAdmin(), $user);
    }
}
