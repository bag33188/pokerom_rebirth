<?php

namespace App\Repositories;

use App\Interfaces\GameRepositoryInterface;
use App\Models\Game;
use App\Models\Rom;
use Illuminate\Database\Eloquent\Collection;

class GameRepository implements GameRepositoryInterface
{
    private Game $game;

    public function __construct(Game $game)
    {
        $this->game = $game;
    }

    public function findGameIfExists(int $gameId): array|Game
    {
        return $this->game->findOrFail($gameId);
    }

    public function getAllGamesSorted(): Collection|array
    {
        return $this->game->all()->sortBy([
            ['rom_id', 'asc'],
            ['generation', 'asc']
        ]);
    }

    public function getRomAssociatedWithGame(int $gameId): Rom
    {
        return $this->findGameIfExists($gameId)->rom()->first();
    }
}
