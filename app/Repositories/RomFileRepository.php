<?php

namespace App\Repositories;

use App\Interfaces\Repository\RomFileRepositoryInterface;
use App\Models\Rom;
use App\Models\RomFile;
use App\Queries\RomFileQueriesTrait as RomFileAggregations;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Collection as ResourceCollection;
use Storage;

class RomFileRepository implements RomFileRepositoryInterface
{
    use RomFileAggregations {
        sortByLengthAscFilenameAsc as private; # public
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
        return RomFile::all()->sortBy($this->sortByLengthAscFilenameAsc());
    }

    public function getAllRomFilesSortedWithRomData(): Collection
    {
        return RomFile::with('rom')->get()->sortBy($this->sortByLengthAscFilenameAsc());
    }

    public function findRomFileByFilename(string $romFilename): ?RomFile
    {
        return RomFile::where('filename', '=', $romFilename)->first();
    }

    public function getRomFilesCount(): int
    {
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

    public function getAllRomFileLengthsKibibytes(): Collection
    {
        return RomFile::project($this->calcLengthsOfRomFilesKibibytes())->get();
    }

    public function getAllRomFileNameAndFileTypeValues(): Collection
    {
        return RomFile::project($this->splitRomFilenamesIntoFileEntityValues())->get();
    }

    public function getRomFilesMetadata(): ResourceCollection
    {
        $columns = array('filename', 'filetype', 'filesize');
        return $this->queryRomFileMetadata($columns)->map(function (array $romFileMetadata): array {
            $romFileMetadata['_id'] = (string)$romFileMetadata['_id'];
            return $romFileMetadata;
        });
    }

    /**
     * @return array|string[]
     */
    public function listAllFilesInStorage(): array
    {
        return Storage::disk(ROM_FILES_DIRNAME)->files('/');
    }

    /**
     * @return array|string[]
     */
    public function listRomFilesInStorage(): array
    {
        $filteredRomFiles = array_filter(
            $this->listAllFilesInStorage(),
            fn(string $romFilename): false|int => preg_match(ROM_FILENAME_PATTERN, $romFilename)
        );
        return array_values($filteredRomFiles);
    }
}
