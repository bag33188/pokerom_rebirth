<?php

namespace App\Repositories;

use App\Interfaces\Repository\RomRepositoryInterface;
use App\Models\Game;
use App\Models\Rom;
use App\Models\RomFile;
use App\Queries\RomQueries;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\DB;

class RomRepository implements RomRepositoryInterface
{
    use RomQueries;

    public function getSingleRomWithGameInfo(int $romId): Rom
    {
        return Rom::with('game')->where('id', '=', $romId)->firstOrFail();
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
        return Rom::all()->sortBy([['game_id', 'asc'], ['rom_size', 'asc']]);
    }

    public function getGameAssociatedWithRom(int $romId): Game
    {
        return $this->findRomIfExists($romId)->game()->firstOrFail();
    }

    public function getFileAssociatedWithRom(int $romId): RomFile
    {
        return $this->findRomIfExists($romId)->romFile()->firstOrFail();
    }

    /**
     * This will attempt to cross-reference the MongoDB database and check if there is a file
     * with the same name of the roms name plus its extension (rom type)
     *
     * @param int $romId
     * @return \App\Models\RomFile|null
     */
    public function searchForFileMatchingRom(int $romId): ?RomFile
    {
        // @ symbol is needed since using `findOrFail` (which throws exception on fail)
        $romFileName = @$this->findRomIfExists($romId)->getRomFileName();
        return RomFile::where('filename', '=', $romFileName)
            ->first();
    }

    public function getFormattedRomSize(int $romSize): string
    {
        [$query, $bindings] = $this->formatRomSize($romSize)->getValues();
        return DB::selectOne($query, $bindings)->romSize;
    }
}
