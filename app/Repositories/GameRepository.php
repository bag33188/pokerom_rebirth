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
        sortByRomIdAscGenerationAsc as private;
        formatGameType as private formatGameTypeQuery;
        findRomsWithNoGame as private findRomsWithNoGameQuery;
    }

    public function findGameIfExists(int $gameId): Game
    {
        return Game::findOrFail($gameId);
    }

    public function getAllGamesSorted(): Collection
    {
        return Game::all()->sortBy($this->sortByRomIdAscGenerationAsc());
    }

    public function getRomAssociatedWithGame(int $gameId): Rom
    {
        return $this->findGameIfExists($gameId)->rom()->first();
    }

    public function getFormattedGameType(string $gameType): string
    {
        [$query, $bindings] = $this->formatGameTypeQuery($gameType)->getValues();
        return DB::selectOne($query, $bindings)->gameType;
    }

    public function getAllRomsWithNoGame(): Collection
    {
        ['query' => $query] = $this->findRomsWithNoGameQuery()->toArray();
        return Rom::fromQuery($query);
    }

    public function getGamesCount(): int
    {
        return Game::all()->count();
    }
}
