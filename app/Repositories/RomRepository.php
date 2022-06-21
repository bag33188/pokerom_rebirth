<?php

namespace App\Repositories;

use App\Factories\RomRepositoryFactory;
use App\Models\File;
use App\Models\Game;
use App\Models\Rom;
use Illuminate\Database\Eloquent\Collection;

class RomRepository implements RomRepositoryFactory
{
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
     * @param int $romId
     * @return \App\Models\File|null
     */
    public function searchForFileMatchingRom(int $romId): ?File
    {
        return File::where('filename', '=', $this->findRomIfExists($romId)->getRomFileName())->first();
    }
}
