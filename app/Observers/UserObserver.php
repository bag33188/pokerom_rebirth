<?php

namespace App\Observers;

use App\Models\User;
use App\Notifications\WelcomeNotification;
use Illuminate\Support\Facades\Notification;

class UserObserver
{
    public bool $afterCommit = true;

    public function created(User $user): void
    {
        Notification::send($user, new WelcomeNotification($user->name));
    }
}
