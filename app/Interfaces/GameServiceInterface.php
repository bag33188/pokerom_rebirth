<?php

namespace App\Interfaces;

use App\Models\Game;

interface GameServiceInterface
{
    public function associateGameWithRom(Game $game, int $romId);
}
