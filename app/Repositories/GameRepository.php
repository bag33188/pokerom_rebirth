<?php

namespace App\Repositories;

use App\Interfaces\GameRepositoryInterface;
use App\Models\Game;
use App\Models\Rom;

class GameRepository implements GameRepositoryInterface
{
    private Game $game;
    public function __construct(Game $game)
    {
        $this->game = $game;
    }

    public function showAssociatedRom(int $gameId): Rom
    {
        $associatedRom = $this->game->findOrFail($gameId)->rom()->first();
        return $associatedRom;
    }
}
