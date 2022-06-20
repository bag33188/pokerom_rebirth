<?php

namespace App\Repositories;

use App\Interfaces\FileRepositoryInterface;
use App\Models\File;
use App\Models\Rom;
use Illuminate\Database\Eloquent\Collection;

class FileRepository implements FileRepositoryInterface
{
    private File $file;

    public function __construct(File $file)
    {
        $this->file = $file;
    }

    public function findFileIfExists(string $fileId): File
    {
        return $this->file->findOrFail($fileId);
    }

    public function getRomAssociatedWithFile(string $fileId): Rom
    {
        return $this->findFileIfExists($fileId)->rom()->firstOrFail();
    }

    public function getAllFilesSorted(): Collection
    {
        return $this->file->all()->sortBy([['length', 'asc'], ['filename', 'asc']]);
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
