<?php

namespace App\Repositories;

use App\Interfaces\Repository\GameRepositoryInterface;
use App\Models\Game;
use App\Models\Rom;
use App\Queries\GameQueriesTrait as GameQueries;
use DB;
use Illuminate\Database\Eloquent\Collection;

class GameRepository implements GameRepositoryInterface
{
    use GameQueries {
        formatGameType as private;
        findRomsWithNoGame as private;
    }

    public function findGameIfExists(int $gameId): Game
    {
        return Game::findOrFail($gameId);
    }

    public function getAllGamesSorted(): Collection
    {
        return Game::all()->sortBy(array(
            ['rom_id', 'asc'],
            ['generation', 'asc']
        ));
    }

    public function getRomAssociatedWithGame(int $gameId): Rom
    {
        return $this->findGameIfExists($gameId)->rom()->first();
    }

    public function getFormattedGameType(string $gameType): string
    {
        [$query, $bindings] = $this->formatGameType($gameType)->getValues();
        return DB::selectOne($query, $bindings)->gameType;
    }

    public function getAllRomsWithNoGame(): Collection
    {
        ['query' => $query] = $this->findRomsWithNoGame()->toArray();
        return Rom::fromQuery($query);
    }

    public function getGamesCount(): int
    {
        return Game::all()->count();
    }
}
