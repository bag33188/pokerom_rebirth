<?php

namespace App\Interfaces;

use App\Models\Game;
use App\Models\Rom;

interface GameServiceInterface{
    public function associateGameWithRom(Game $game, int $romId);
}
