<?php

namespace App\Repositories;

use App\Interfaces\GameRepositoryInterface;
use App\Models\Game;
use App\Models\Rom;

class GameRepository implements GameRepositoryInterface
{


    public function showAssociatedRom(int $gameId): Rom
    {
        $associatedRom = Game::findOrFail($gameId)->rom()->first();
        return $associatedRom;
    }
}
