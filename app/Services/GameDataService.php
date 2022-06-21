<?php

namespace App\Services;

use App\Interfaces\GameServiceInterface;
use Symfony\Component\HttpFoundation\Response as ResponseAlias;
use RomRepo;

class GameDataService implements GameServiceInterface
{
    public function createGame(int $romId, array $data): JsonServiceResponse
    {
        $rom = RomRepo::findRomIfExists($romId);
        $game = $rom->game()->create($data);
        // associate game object with rom object
        $rom->refresh(); // reload rom resource to included updated relationships
        $game->rom()->associate($rom);
        $game->saveQuietly();
        return new JsonServiceResponse(['data' => $game], ResponseAlias::HTTP_CREATED);
    }
}
