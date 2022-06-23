<?php

namespace App\Interfaces;

use App\Http\Resources\GameResource;
use App\Models\Game;
use App\Models\Rom;

interface GameDataServiceInterface
{
    public function associateRomWithGame(Rom $rom, Game $game);
}
