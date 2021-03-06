<?php

namespace App\Observers;

use App\Events\GameCreated;
use App\Models\Game;
use Str;

class GameObserver
{
    /** @var bool Use database relationships to update models */
    private static bool $_USE_DB_LOGIC = true;


    /**
     * Handle events after all transactions are committed.
     *
     * @var bool
     */
    public bool $afterCommit = false;

    public function creating(Game $game): void
    {
        $game->slug = Str::slug($game->game_name);
    }

    public function created(Game $game): void
    {
        $rom = $game->rom()->first();
        GameCreated::dispatch($game, $rom);

        if (self::$_USE_DB_LOGIC === false) {
            $rom->has_game = TRUE;
            $rom->game_id = $game->id;
            $rom->saveQuietly();
        }
    }

    public function updating(Game $game): void
    {
        $game->slug = Str::slug($game->game_name);
    }

    public function deleted(Game $game): void
    {
        if (self::$_USE_DB_LOGIC === false) {
            $rom = $game->rom()->first();
            $rom->game_id = NULL;
            $rom->has_game = FALSE;
            $rom->saveQuietly();
        }
    }
}
