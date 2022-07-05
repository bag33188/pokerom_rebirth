<?php

namespace App\Repositories;

use App\Interfaces\Repository\RomFileRepositoryInterface;
use App\Models\Rom;
use App\Models\RomFile;
use App\Services\GridFS\RomFilesAggregationsTrait;
use Illuminate\Database\Eloquent\Collection;
use Jenssegers\Mongodb\Helpers\EloquentBuilder;
use Utils\Modules\FileMethods;

class RomFileRepository implements RomFileRepositoryInterface
{
    use RomFilesAggregationsTrait;

    public function findFileIfExists(string $romFileId): RomFile
    {
        return RomFile::findOrFail($romFileId);
    }

    public function getRomAssociatedWithFile(string $romFileId): Rom
    {
        return $this->findFileIfExists($romFileId)->rom()->firstOrFail();
    }

    public function getAllFilesSorted(): Collection
    {
        return RomFile::all()->sortBy([['length', 'asc'], ['filename', 'asc']]);
    }

    public function getFileByFilename(string $romFilename): RomFile
    {
        return RomFile::where('filename', '=', $romFilename)->first();
    }

    public function searchForRomMatchingFile(string $romFileId): ?Rom
    {
        list($romName, $romExtension) =
            FileMethods::splitFilenameIntoParts($this->findFileIfExists($romFileId)->filename);
        return Rom::where([
            ['rom_name', '=', $romName, 'and'],
            ['rom_type', '=', $romExtension, 'and']
        ])->where(function (EloquentBuilder $query) {
            $query
                ->where('has_file', '=', FALSE)
                ->orWhere('file_id', '=', NULL);
        })->limit(1)->first();
    }

    public function getFileLengthsKibibytes(): Collection
    {
        return RomFile::project($this->calcLengthKibibytes())->get();
    }

    public function getFileLengthsGibibytes(): Collection
    {
        return RomFile::project($this->calcLengthGibibytes())->get();
    }

    public function getFileLengthsMebibytes(): Collection
    {
        return RomFile::project($this->calcLengthMebibytes())->get();
    }

    public function calcTotalSizeOfAllRomFiles(): int
    {
        return RomFile::sum('length');
    }
}
