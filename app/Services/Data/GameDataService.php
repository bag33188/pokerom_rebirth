<?php

namespace App\Services\Data;

use App\Interfaces\Service\GameDataServiceInterface;
use App\Models\Game;
use RomRepo;

class GameDataService implements GameDataServiceInterface
{
    public function createGameFromRomId(int $romId, array $data): Game
    {
        $rom = RomRepo::findRomIfExists($romId);
        return $rom->game()->create($data);
    }
}
