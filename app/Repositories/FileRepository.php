<?php

namespace App\Repositories;

use App\Exceptions\NotFoundException;
use App\Interfaces\FileRepositoryInterface;
use App\Models\File;
use App\Models\Rom;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Query\Builder;

class FileRepository implements FileRepositoryInterface
{
    private File $file;

    public function __construct(File $file)
    {
        $this->file = $file;
    }

    public function findFileIfExists(string $fileId): array|File
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

    public function getAllFilesSorted(): array|Collection
    {
        return $this->file->all()->sortBy([['length', 'asc'], ['filename', 'asc']]);
    }

    public function searchForRomMatchingFile(string $fileId): Rom|Builder
    {
        [$name, $ext] = explode('.',
            $this->findFileIfExists($fileId)->filename, 2);
        return Rom::whereNull('file_id')->where([
            ['rom_name', '=', $name],
            ['rom_type', '=', $ext],
            ['has_file', '=', false],
        ]);
    }
}
