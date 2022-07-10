<?php

namespace App\Interfaces\Service;

use App\Models\Game;
use Illuminate\Database\Eloquent\Model;

interface GameServiceInterface
{
    public function createGameFromRomId(int $romId, array $gameData): Model|Game;
}
