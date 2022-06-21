<?php

namespace App\Repositories;

use App\Factories\GameRepositoryFactory;
use App\Models\Game;
use App\Models\Rom;
use Illuminate\Database\Eloquent\Collection;

class GameRepository implements GameRepositoryFactory
{

    public function findGameIfExists(int $gameId): Game
    {
        return Game::findOrFail($gameId);
    }

    public function getAllGamesSorted(): Collection
    {
        return Game::all()->sortBy([
            ['rom_id', 'asc'],
            ['generation', 'asc']
        ]);
    }

    public function getRomAssociatedWithGame(int $gameId): Rom
    {
        return $this->findGameIfExists($gameId)->rom()->first();
    }
}
