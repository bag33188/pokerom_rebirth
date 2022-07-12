<?php

namespace App\Repositories;

use App\Interfaces\Repository\RomFileRepositoryInterface;
use App\Models\Rom;
use App\Models\RomFile;
use App\Queries\RomFileQueriesTrait;
use Illuminate\Database\Eloquent\Collection;

class RomFileRepository implements RomFileRepositoryInterface
{
    use RomFileQueriesTrait;

    public function findRomFileIfExists(string $romFileId): RomFile
    {
        return RomFile::findOrFail($romFileId);
    }

    public function getRomAssociatedWithFile(string $romFileId): Rom
    {
        return $this->findRomFileIfExists($romFileId)->rom()->firstOrFail();
    }

    public function getAllRomFilesSorted(): Collection
    {
        return RomFile::all()->sortBy([['length', 'asc'], ['filename', 'asc']]);
    }

    public function getRomFileByFilename(string $romFilename): RomFile
    {
        return RomFile::where('filename', '=', $romFilename)->first();
    }

    /**
     * This will attempt to cross-reference the MongoDB database and check if there is a file
     * with the same name of the roms name plus its extension (rom type)
     *
     * @param Rom $rom
     * @return \App\Models\RomFile|null
     */
    public function searchForRomFileMatchingRom(Rom $rom): ?RomFile
    {
        return RomFile::where('filename', '=', $rom->getRomFileName())
            ->first();
    }

    /*
     * Aggregations
     */

    public function getRomFileLengthsKibibytes(): Collection
    {
        return RomFile::project($this->calcLengthsOfRomFilesKibibytes())->get();
    }

    public function getRomFileLengthsGibibytes(): Collection
    {
        return RomFile::project($this->calcLengthsOfRomFilesGibibytes())->get();
    }

    public function getRomFileLengthsMebibytes(): Collection
    {
        return RomFile::project($this->calcLengthsOfRomFilesMebibytes())->get();
    }

    public function getLengthOfRomFileWithLargestFileSize(): int
    {
        return RomFile::max('length');
    }

    public function getTotalSizeOfAllRomFiles(): int
    {
        return RomFile::sum('length');
    }
}
