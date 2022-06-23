<?php

namespace App\Services;

use App\Interfaces\GameDataServiceInterface;
use App\Models\Game;
use App\Models\Rom;

class GameDataDataService implements GameDataServiceInterface
{
    public function associateRomWithGame(Rom $rom, Game $game)
    {
        $rom->refresh(); // reload rom resource to included updated relationships
        $game->rom()->associate($rom);
        $game->saveQuietly();
    }
}
