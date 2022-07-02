<?php

namespace App\Repositories;

use App\Interfaces\Repository\GameRepositoryInterface;
use App\Models\Game;
use App\Models\Rom;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\DB;

class GameRepository implements GameRepositoryInterface
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


    public function getProperGameTypeString(string $gameType): string
    {
        $sql =
            DB::raw(/** @lang MariaDB */ "SELECT GetProperGameTypeString(?) AS gameType;");
        return DB::selectOne($sql, [$gameType])->gameType;
    }

    public function getAllRomsWithNoGame(): array
    {
        // todo: implement toJson and arrayable??
        $sql = /** @lang MariaDB */
            "CALL FindRomsWithNoGame";
        return DB::select($sql);
    }
}
