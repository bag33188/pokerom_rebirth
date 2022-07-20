<?php

namespace App\Interfaces\Service;

use App\Models\Game;
use Illuminate\Support\Facades\Date;

interface GameServiceInterface
{
    /**
     * @param int $romId
     * @param array{game_name: string, game_type: string, region: string, generation: int, date_released: Date} $gameData
     * @return Game
     */
    public function createGameFromRomId(int $romId, array $gameData): Game;
}
