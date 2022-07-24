<?php

namespace App\Observers;

use App\Events\UserCreated;
use App\Events\UserDeleting;
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
        UserCreated::dispatch($user);
    }

    public function updated(User $user): void
    {
        $this->userService->revokeApiTokens();
    }

    public function deleting(User $user): void
    {
        UserDeleting::dispatchUnless($user->isAdmin(), $user);
    }
}
