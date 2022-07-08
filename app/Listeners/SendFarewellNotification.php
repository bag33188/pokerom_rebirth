<?php

namespace App\Listeners;

use App\Events\UserDeleted;
use App\Notifications\FarewellNotification;
use Illuminate\Support\Facades\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;


class SendFarewellNotification implements ShouldQueue
{
    use InteractsWithQueue;

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
     * @param UserDeleted $event
     * @return void
     */
    public function handle(UserDeleted $event): void
    {
        Notification::send($event->user, new FarewellNotification($event->user));
    }
}
