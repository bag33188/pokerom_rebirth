<?php

namespace App\Services;

use App\Http\Resources\GameResource;
use App\Interfaces\GameDataServiceInterface;
use RomRepo;

class GameDataDataService implements GameDataServiceInterface
{
    public function createGame(int $romId, array $data): GameResource
    {
        $rom = RomRepo::findRomIfExists($romId);
        $game = $rom->game()->create($data);
        // associate game object with rom object
        $rom->refresh(); // reload rom resource to included updated relationships
        $game->rom()->associate($rom);
        $game->saveQuietly();
        return (new GameResource($game));
    }
}
