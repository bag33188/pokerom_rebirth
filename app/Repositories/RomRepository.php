<?php

namespace App\Repositories;

use App\Interfaces\RomRepositoryInterface;
use App\Models\File;
use App\Models\Game;
use App\Models\Rom;
use Illuminate\Database\Eloquent\Collection;

class RomRepository implements RomRepositoryInterface
{
    private Rom $rom;

    public function __construct(Rom $rom)
    {
        $this->rom = $rom;
    }

    public function findRomIfExists(int $romId): Rom
    {
        return $this->rom->findOrFail($romId);
    }

    public function getAllRomsSorted(): Collection
    {
        return $this->rom->all()->sortBy([['game_id', 'asc'], ['rom_size', 'asc']]);
    }

    public function getGameAssociatedWithRom(int $romId): Game
    {
        $associatedGame = $this->findRomIfExists($romId)->game()->firstOrFail();
        return $associatedGame;
    }

    public function getFileAssociatedWithRom(int $romId): File
    {
        $associatedFile = $this->findRomIfExists($romId)->file()->firstOrFail();
        return $associatedFile;
    }

    /**
     * This will attempt to cross-reference the MongoDB database and check if there is a file
     * with the same name of the roms name plus its extension (rom type)
     * @param int $romId
     * @return File|null
     */
    public function searchForFileMatchingRom(int $romId): ?File
    {
        return File::where('filename', '=', $this->findRomIfExists($romId)->getRomFileName())->first();
    }
}
