<?php

namespace App\Services;

use App\Interfaces\GameServiceInterface;
use App\Interfaces\RomRepositoryInterface;
use App\Models\Game;
use App\Models\Rom;

class GameService implements GameServiceInterface
{
    protected RomRepositoryInterface $romRepository;

    public function __construct(RomRepositoryInterface $romRepository)
    {
        $this->romRepository = $romRepository;
    }

    public function createGame(int $romId, array $data): Game
    {
        $rom = $this->romRepository->findRomIfExists($romId);
        $game = $rom->game()->create($data);
        $this->associateGameWithRom($game, $rom);
        return $game;
    }

    private function associateGameWithRom(Game $game, Rom $rom)
    {
        $rom->refresh();
        $game->rom()->associate($rom);
        $game->saveQuietly();
    }
}
