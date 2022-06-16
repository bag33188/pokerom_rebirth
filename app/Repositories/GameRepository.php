<?php

namespace App\Repositories;

use App\Interfaces\GameRepositoryInterface;
use App\Models\Game;
use App\Models\Rom;

class GameRepository implements GameRepositoryInterface
{
    public function associateGameWithRom(Game $game, Rom &$rom): Game
    {
        $rom = $rom->refresh();
        $game->rom()->associate($rom);
        $game->save();
        return $game;
    }

    public function showRom(int $gameId): Rom|null
    {
        $associateRom = Game::findOrFail($gameId)->rom()->first();
        return $associateRom;
    }
}
