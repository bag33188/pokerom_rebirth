<?php

namespace App\Repositories;

use App\Interfaces\RomRepositoryInterface;
use App\Models\File;
use App\Models\Game;
use App\Models\Rom;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\DB;

class RomRepository implements RomRepositoryInterface
{
    public function getSingleRomWithGameAndFileInfo(int $romId): Rom
    {
        return Rom::with(['game', 'file'])->where('id', '=', $romId)->firstOrFail();
    }

    public function getRomsWithGameAndFileInfo(): Collection
    {
        return Rom::with(['game', 'file'])->get();
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

    public function getFileAssociatedWithRom(int $romId): File
    {
        return $this->findRomIfExists($romId)->file()->firstOrFail();
    }

    /**
     * This will attempt to cross-reference the MongoDB database and check if there is a file
     * with the same name of the roms name plus its extension (rom type)
     *
     * @param int $romId
     * @return \App\Models\File|null
     */
    public function searchForFileMatchingRom(int $romId): ?File
    {
        return File::where('filename', '=', @$this->findRomIfExists($romId)->getRomFileName())->first();
    }

    public function getReadableRomSize(int $size): string
    {
        $sql = /** @lang MariaDB */
            "SELECT CalcReadableRomSize(?) AS readable_size;";
        return DB::selectOne($sql, [$size])->readable_size;
    }
}
