<?php

namespace App\Services;

use App\Events\GameCreated;
use App\Interfaces\GameDataServiceInterface;
use App\Models\Game;
use RomRepo;

class GameDataDataService implements GameDataServiceInterface
{
    public function createGameFromRomId(int $romId, array $data): Game
    {
        $rom = RomRepo::findRomIfExists($romId);
        $game = $rom->game()->create($data);
        GameCreated::dispatch($game, $rom);
        return $game;
    }
}
