<?php

namespace App\Repositories;

use App\Interfaces\Repository\RomFileRepositoryInterface;
use App\Models\Rom;
use App\Models\RomFile;
use App\Queries\RomFileQueriesTrait;
use App\Queries\RomQueriesTrait;
use Illuminate\Database\Eloquent\Collection;

//use Jenssegers\Mongodb\Helpers\EloquentBuilder;

class RomFileRepository implements RomFileRepositoryInterface
{
    use RomFileQueriesTrait, RomQueriesTrait;

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

    public function searchForRomMatchingFile(string $romFilename): ?Rom
    {
//        list($romName, $romExtension) =
//            FileUtils::splitFilenameIntoParts($this->findRomFileIfExists($romFileId)->filename);
//        return Rom::where([
//            ['rom_name', '=', $romName, 'and'],
//            ['rom_type', '=', $romExtension, 'and']
//        ])->where(function (EloquentBuilder $query) {
//            $query
//                ->where('has_file', '=', FALSE)
//                ->orWhere('file_id', '=', NULL);
//        })->limit(1)->first();
        list($query, $bindings) = $this->findMatchingRomFromFilename($romFilename)->getValues();
        return Rom::fromQuery($query, $bindings)->first();
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
