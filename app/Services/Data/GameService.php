<?php

namespace App\Services\Data;

use App\Interfaces\Service\GameServiceInterface;
use App\Models\Game;
use RomRepo;

class GameService implements GameServiceInterface
{
    public function createGameFromRomId(int $romId, array $gameData): Game
    {
        $rom = RomRepo::findRomIfExists($romId);
        return $rom->game()->create($gameData);
    }
}
