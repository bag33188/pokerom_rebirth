<?php

namespace App\Repositories;

use App\Interfaces\Repository\RomFileRepositoryInterface;
use App\Models\Rom;
use App\Models\RomFile;
use App\Services\GridFS\RomFilesAggregationsTrait;
use Illuminate\Database\Eloquent\Collection;

class RomFileRepository implements RomFileRepositoryInterface
{
    use RomFilesAggregationsTrait;

    public function findFileIfExists(string $fileId): RomFile
    {
        return RomFile::findOrFail($fileId);
    }

    public function getRomAssociatedWithFile(string $fileId): Rom
    {
        return $this->findFileIfExists($fileId)->rom()->firstOrFail();
    }

    public function getAllFilesSorted(): Collection
    {
        return RomFile::all()->sortBy([['length', 'asc'], ['filename', 'asc']]);
    }

    public function getFileByFilename(string $filename): RomFile
    {
        return RomFile::where('filename', '=', $filename)->first();
    }

    public function searchForRomMatchingFile(string $fileId): ?Rom
    {
        [$name, $ext] = explode('.',
            $this->findFileIfExists($fileId)['filename'], 2);
        return Rom::where([
            ['rom_name', '=', $name, 'and'],
            ['rom_type', '=', $ext, 'and']
        ])->where([
            ['has_file', '=', false, 'or'],
            ['file_id', '=', null]
        ])->first();
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
