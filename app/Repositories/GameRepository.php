<?php

namespace App\Repositories;

use App\Interfaces\Repository\GameRepositoryInterface;
use App\Models\Game;
use App\Models\Rom;
use App\Queries\GameQueries;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\DB;

class GameRepository implements GameRepositoryInterface
{
    use GameQueries;

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


    public function getFormattedGameType(string $gameType): string
    {
        [$query, $bindings] = array_values($this->formatGameTypeString($gameType));
        return DB::selectOne($query, $bindings)->gameType;
    }

    public function getAllRomsWithNoGame(): array
    {
        [$query] = array_values($this->findRomsWithNoGame()['query']);
        return DB::select($query);
    }
}
