<?php

namespace App\Services;

use App\Interfaces\GameServiceInterface;
use Classes\JsonDataServiceResponse;
use RomRepo;
use Symfony\Component\HttpFoundation\Response as ResponseAlias;

class GameDataService implements GameServiceInterface
{
    public function createGame(int $romId, array $data): JsonDataServiceResponse
    {
        $rom = RomRepo::findRomIfExists($romId);
        $game = $rom->game()->create($data);
        // associate game object with rom object
        $rom->refresh(); // reload rom resource to included updated relationships
        $game->rom()->associate($rom);
        $game->saveQuietly();
        return new JsonDataServiceResponse(['data' => $game], ResponseAlias::HTTP_CREATED);
    }
}
