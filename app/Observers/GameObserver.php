<?php

namespace App\Observers;

use App\Events\GameCreated;
use App\Interfaces\Action\GameActionsInterface;
use App\Models\Game;

class GameObserver
{
    public bool $afterCommit = false;

    /** @var bool Use database relationships to update models */
    private static bool $useDbLogic = true;

    public function __construct(private readonly GameActionsInterface $gameActions)
    {
    }

    public function creating(Game $game): void
    {
        $this->gameActions->slugifyGameNameFromGameObject($game);
    }

    public function created(Game $game): void
    {
        $rom = $game->rom()->first();
        GameCreated::dispatch($game, $rom);

        if (self::$useDbLogic === false) {
            $rom->has_game = true;
            $rom->game_id = $game->id;
            $rom->saveQuietly();
        }
    }

    public function updating(Game $game): void
    {
        $this->gameActions->slugifyGameNameFromGameObject($game);
    }

    public function deleted(Game $game): void
    {
        if (self::$useDbLogic === false) {
            $rom = $game->rom()->first();
            $rom->game_id = null;
            $rom->has_game = false;
            $rom->saveQuietly();
        }
    }
}
