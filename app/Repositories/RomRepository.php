<?php

namespace App\Repositories;

use App\Exceptions\NotFoundException;
use App\Interfaces\RomRepositoryInterface;
use App\Models\File;
use App\Models\Game;
use App\Models\Rom;
use Illuminate\Database\Eloquent\Collection;
use Jenssegers\Mongodb\Eloquent\Builder as QueryBuilder;

class RomRepository implements RomRepositoryInterface
{
    private Rom $rom;

    public function __construct(Rom $rom)
    {
        $this->rom = $rom;
    }

    public function findRomIfExists(int $romId): Rom|array
    {
        return $this->rom->findOrFail($romId);
    }

    public function getAllRomsSorted(): Collection|array
    {
        return $this->rom->all()->sortBy([['game_id', 'asc'], ['rom_size', 'asc']]);
    }

    public function getGameAssociatedWithRom(int $romId): Game
    {
        return $this->findRomIfExists($romId)->game()->firstOrFail();
    }

    /**
     * @throws NotFoundException
     */
    public function getFileAssociatedWithRom(int $romId): File
    {
        $associatedFile = $this->findRomIfExists($romId)->file()->first();
        return $associatedFile ?? throw new NotFoundException('this rom does not have a file');
    }

    /**
     * This will attempt to cross-reference the MongoDB database and check if there is a file
     * with the same name of the roms name plus its extension (rom type)
     * @param int $romId
     * @return QueryBuilder|File|null
     */
    public function searchForFileMatchingRom(int $romId): QueryBuilder|null|File
    {
        return File::where('filename', '=', $this->findRomIfExists($romId)->getRomFileName());
    }
}
