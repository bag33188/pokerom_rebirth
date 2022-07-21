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
        $game = $event->game;
        $rom = $event->rom;
        Game::withoutEvents(function () use ($game, $rom) {
            $rom->refresh();
            $game->rom()->associate($rom);
            $game->save();
        });
    }
}
