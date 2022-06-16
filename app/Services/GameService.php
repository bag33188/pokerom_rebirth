<?php

namespace App\Services;

use App\Interfaces\GameServiceInterface;
use App\Models\Game;
use App\Models\Rom;

class GameService implements GameServiceInterface {
    public function associateGameWithRom(Game $game, int $romId): Game
    {
        $rom = Rom::findOrFail($romId);
        $game->rom()->associate($rom);
        $game->save();
        return $game;
    }
}
