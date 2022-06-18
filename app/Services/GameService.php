<?php

namespace App\Services;

use App\Interfaces\GameServiceInterface;
use App\Models\Game;
use App\Models\Rom;

class GameService extends RomService implements GameServiceInterface
{
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
