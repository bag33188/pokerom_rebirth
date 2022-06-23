<?php

namespace App\Services;

use App\Events\GameCreated;
use App\Interfaces\GameDataServiceInterface;
use App\Models\Game;
use Illuminate\Database\Eloquent\Model;
use RomRepo;

class GameDataDataService implements GameDataServiceInterface
{
    public function createGameFromRomId(int $romId, array $data): Model|Game
    {
        $rom = RomRepo::findRomIfExists($romId);
        $game = $rom->game()->create($data);
        event(new GameCreated($game, $rom));
        return $game;
    }
}
