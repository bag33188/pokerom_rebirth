<?php

namespace App\Repositories;

use App\Interfaces\FileRepositoryInterface;
use App\Models\File;
use App\Models\Rom;
use Illuminate\Database\Eloquent\Collection;

class FileRepository implements FileRepositoryInterface
{
    public function findFileIfExists(string $fileId): File
    {
        return File::findOrFail($fileId);
    }

    public function getRomAssociatedWithFile(string $fileId): Rom
    {
        return $this->findFileIfExists($fileId)->rom()->firstOrFail();
    }

    public function getAllFilesSorted(): Collection
    {
        return File::all()->sortBy([['length', 'asc'], ['filename', 'asc']]);
    }

    public function getFileByFilename(string $filename): File
    {
        return File::where('filename', '=', $filename)->first();
    }

    public function searchForRomMatchingFile(string $fileId): ?Rom
    {
        [$name, $ext] = explode('.',
            $this->findFileIfExists($fileId)['filename'], 2);
        return Rom::where([
            ['rom_name', '=', $name, 'and'],
            ['rom_type', '=', $ext, 'and'],
            ['has_file', '=', false, 'or'],
            ['file_id', '=', null]
        ])->first();
    }
}
