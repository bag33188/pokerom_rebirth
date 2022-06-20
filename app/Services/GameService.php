<?php

namespace App\Services;

use App\Interfaces\GameServiceInterface;
use App\Interfaces\RomRepositoryInterface;
use Symfony\Component\HttpFoundation\Response as ResponseAlias;

class GameService implements GameServiceInterface
{
    protected RomRepositoryInterface $romRepository;

    public function __construct(RomRepositoryInterface $romRepository)
    {
        $this->romRepository = $romRepository;
    }

    public function createGame(int $romId, array $data): JsonServiceResponse
    {
        $rom = $this->romRepository->findRomIfExists($romId);
        $game = $rom->game()->create($data);
        // associate game object with rom object
        $rom->refresh(); // reload rom resource to included updated relationships
        $game->rom()->associate($rom);
        $game->saveQuietly();
        return new JsonServiceResponse(['data' => $game], ResponseAlias::HTTP_CREATED);
    }
}
