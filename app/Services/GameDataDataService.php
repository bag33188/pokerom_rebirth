<?php

namespace App\Services;

use App\Interfaces\GameDataServiceInterface;
use App\Models\Game;
use App\Models\Rom;
use Illuminate\Database\Eloquent\Model;
use RomRepo;

class GameDataDataService implements GameDataServiceInterface
{
    public function associateRomWithGame(Rom $rom, Game $game): void
    {
        $rom->refresh(); // reload rom resource to included updated relationships
        $game->rom()->associate($rom);
        $game->saveQuietly();
    }

    public function createGameFromRomId(int $romId, array $data): Model|Game
    {
        $rom = RomRepo::findRomIfExists($romId);
        return $rom->game()->create($data);
    }
}
