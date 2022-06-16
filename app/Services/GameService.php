<?php

namespace App\Services;

use App\Interfaces\GameServiceInterface;
use App\Models\Game;
use App\Models\Rom;

class GameService implements GameServiceInterface {
    public function associateGameWithRom(Game $game, int $romId): Game
    {
        $rom = Rom::findOrFail($romId);
        $this->game->rom()->associate($rom);
        $this->game->save();
        return $this->game;
    }
}
