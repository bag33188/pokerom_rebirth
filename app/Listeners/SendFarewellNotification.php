<?php

namespace App\Listeners;

use App\Events\UserDeleting;
use App\Notifications\FarewellNotification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Facades\Notification;


class SendFarewellNotification implements ShouldQueue
{
    public bool $afterCommit = true;

    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param UserDeleting $event
     * @return void
     */
    public function handle(UserDeleting $event): void
    {
        $partingUser = $event->user;
        Notification::send($partingUser, new FarewellNotification($partingUser));
    }
}
