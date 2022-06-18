<?php

namespace App\Services;

use App\Interfaces\GameServiceInterface;
use App\Models\Game;
use App\Models\Rom;

class GameService implements GameServiceInterface {
    public function associateGameWithRom(Game $game, int $romId): Game
    {
        $rom = Rom::find($romId);
        $game->rom()->associate($rom);
        $game->saveQuietly();
        return $game;
    }
}
