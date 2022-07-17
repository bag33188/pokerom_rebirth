<?php

namespace App\Repositories;

use App\Interfaces\Repository\RomFileRepositoryInterface;
use App\Models\Rom;
use App\Models\RomFile;
use App\Queries\RomFileQueriesTrait as RomFileAggregations;
use Illuminate\Database\Eloquent\Collection;

class RomFileRepository implements RomFileRepositoryInterface
{
    use RomFileAggregations {
        romFileSumLength as private;
        romFileMaxLength as private;
    }

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

    public function getRomFilesCount(): int
    {
        return $this->countRomFiles();
    }

    public function getAllRomFileLengthsKibibytes(): Collection
    {
        return RomFile::project($this->calcLengthsOfRomFilesKibibytes())->get();
    }

    public function getAllRomFileNameAndFileTypeValues(): Collection
    {
        return RomFile::project($this->splitRomFilenamesIntoFileEntityValues())->get();
    }

    public function getLengthOfRomFileWithLargestFileSize(): int
    {
        return $this->romFileMaxLength();
    }

    public function getTotalSizeOfAllRomFiles(): int
    {
        return $this->romFileSumLength();
    }
}
