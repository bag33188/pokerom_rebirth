<?php

namespace App\Repositories;

use App\Interfaces\RomFileRepositoryInterface;
use App\Models\RomFile;
use App\Models\Rom;
use Illuminate\Database\Eloquent\Collection;

class RomFileRepository implements RomFileRepositoryInterface
{
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
            ['rom_type', '=', $ext, 'and'],
            ['has_file', '=', false, 'and'],
            ['file_id', '=', null]
        ])->first();
    }
}
