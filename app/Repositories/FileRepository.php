<?php

namespace App\Repositories;

use App\Exceptions\NotFoundException;
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

    /**
     * @throws NotFoundException
     */
    public function getRomAssociatedWithFile(string $fileId): Rom
    {
        $associatedRom = $this->findFileIfExists($fileId)->rom()->first();
        return $associatedRom ??
            throw new NotFoundException('no rom is associated with this file');
    }

    public function getAllFilesSorted(): Collection
    {
        return $this->file->all()->sortBy([['length', 'asc'], ['filename', 'asc']]);
    }

    public function searchForRomMatchingFile(string $fileId): ?Rom
    {
        [$name, $ext] = explode('.',
            $this->findFileIfExists($fileId)->filename, 2);
        return Rom::where([
            ['rom_name', '=', $name, 'and'],
            ['rom_type', '=', $ext, 'and'],
            ['has_file', '=', false],
            ['file_id', '=', null]
        ])->first();
    }
}
