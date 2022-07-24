<?php

namespace App\Repositories;

use App\Interfaces\Repository\RomRepositoryInterface;
use App\Models\Game;
use App\Models\Rom;
use App\Models\RomFile;
use App\Queries\RomQueriesTrait as RomQueries;
use DB;
use Illuminate\Database\Eloquent\Collection;

class RomRepository implements RomRepositoryInterface
{
    use RomQueries {
        findMatchingRomFromFilename as private;
        formatRomSize as private;
    }

    public function getSingleRomWithGameInfo(int $romId): Rom
    {
        return Rom::with('game')->findOrFail($romId);
    }

    public function getRomsWithGameAndFileInfo(): Collection
    {
        return Rom::with(['game', 'romFile'])->get();
    }

    public function findRomIfExists(int $romId): Rom
    {
        return Rom::findOrFail($romId);
    }

    public function getAllRomsSorted(): Collection
    {
        return Rom::all()->sortBy(array(
            ['game_id', 'asc'],
            ['rom_size', 'asc']
        ));
    }

    public function getGameAssociatedWithRom(int $romId): Game
    {
        return $this->findRomIfExists($romId)->game()->firstOrFail();
    }

    public function getRomFileAssociatedWithRom(int $romId): RomFile
    {
        return $this->findRomIfExists($romId)->romFile()->firstOrFail();
    }

    public function searchForRomMatchingRomFile(RomFile $romFile): ?Rom
    {
        ['query' => $query, 'bindings' => $bindings] =
            $this->findMatchingRomFromFilename($romFile->filename)->toArray();
        return Rom::fromQuery($query, $bindings)->first();
    }

    public function getFormattedRomSize(int $romSize): string
    {
        [$query, $bindings] = $this->formatRomSize($romSize)->getValues();
        return DB::selectOne($query, $bindings)->romSize;
    }

    public function getRomsCount(): int
    {
        return Rom::all()->count();
    }
}
