<?php

namespace App\Observers;

use App\Events\UserDeleted;
use App\Events\UserRegistered;
use App\Interfaces\Action\UserActionsInterface;
use App\Models\User;


class UserObserver
{
    /**
     * Handle events after all transactions are committed.
     *
     * @var bool
     */
    public bool $afterCommit = true;

    public function __construct(private readonly UserActionsInterface $userActions)
    {
    }

    public function created(User $user): void
    {
        UserRegistered::dispatch($user);
    }

    public function updated(User $user): void
    {
        $this->userActions->revokeUserTokens();
    }

    public function deleting(User $user): void
    {
        UserDeleted::dispatchUnless($user->isAdmin(), $user);
    }
}
