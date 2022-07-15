<?php

namespace App\Repositories;

use App\Interfaces\Repository\RomFileRepositoryInterface;
use App\Models\Rom;
use App\Models\RomFile;
use App\Queries\RomFileAggregationsTrait as RomFileAggregations;
use Illuminate\Database\Eloquent\Collection;

class RomFileRepository implements RomFileRepositoryInterface
{
    use RomFileAggregations;

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

    public function getAllRomFilesSortedWithRomData(): Collection
    {
        return RomFile::with('rom')->get()->sortBy([['length', 'asc'], ['filename', 'asc']]);
    }

    public function findRomFileByFilename(string $romFilename): ?RomFile
    {
        return RomFile::where('filename', '=', $romFilename)->first();
    }


    /*
     * |----------------------|
     * | MongoDB Aggregations |
     * |----------------------|
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

    public function countRomFiles(): int
    {
        return RomFile::count();
    }
}
