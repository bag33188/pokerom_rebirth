<?php

namespace App\Listeners;

use App\Events\GameCreated;
use App\Models\Game;

class AssociateRomWithGame
{
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
     * @param GameCreated $event
     * @return void
     */
    public function handle(GameCreated $event): void
    {
        Game::withoutEvents(function () use ($event) {
            $event->rom->refresh();
            $event->game->rom()->associate($event->rom);
            $event->game->save();
        });
    }
}
