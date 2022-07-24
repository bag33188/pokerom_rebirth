<?php

namespace App\Repositories;

use App\Actions\RomFileActionsTrait as RomFileActions;
use App\Interfaces\Repository\RomFileRepositoryInterface;
use App\Models\Rom;
use App\Models\RomFile;
use App\Queries\RomFileQueriesTrait as RomFileAggregations;
use Illuminate\Database\Eloquent\Collection;

class RomFileRepository implements RomFileRepositoryInterface
{
    use RomFileAggregations {
        calcLengthsOfRomFilesKibibytes as private;
        splitRomFilenamesIntoFileEntityValues as private;
        sortByLengthAscFilenameAsc as public sortByLengthAscFilenameAscSequence;
    }
    use RomFileActions {
        listFilesInStorage as private;
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
        return RomFile::all()->sortBy($this->sortByLengthAscFilenameAscSequence());
    }

    public function getAllRomFilesSortedWithRomData(): Collection
    {
        return RomFile::with('rom')->get()->sortBy($this->sortByLengthAscFilenameAscSequence());
    }

    public function findRomFileByFilename(string $romFilename): ?RomFile
    {
        return RomFile::where('filename', '=', $romFilename)->first();
    }

    public function getRomFilesCount(): int
    {
        // uses actual mongodb aggregator logic, not php count function
        return RomFile::count("*");
    }

    public function getLengthOfRomFileWithLargestFileSize(): int
    {
        return RomFile::max('length');
    }

    public function getTotalSizeOfAllRomFiles(): int
    {
        return RomFile::sum('length');
    }

    public function getAllRomFileLengthsInKibibytes(): Collection
    {
        return RomFile::project($this->calcLengthsOfRomFilesKibibytes())->get();
    }

    public function getAllRomFileNameAndFileTypeValues(): Collection
    {
        return RomFile::project($this->splitRomFilenamesIntoFileEntityValues())->get();
    }

    /**
     * @return array|string[]
     */
    public function listRomFilesInStorage(): array
    {
        $filteredRomFiles = array_filter(
            $this->listFilesInStorage(),
            fn(string $romFilename): false|int => preg_match(ROM_FILENAME_PATTERN, $romFilename)
        );
        return array_values($filteredRomFiles);
    }
}
