<?php

namespace App\Interfaces;

use App\Models\RomFile;
use App\Models\Rom;
use Illuminate\Database\Eloquent\Collection;

interface RomFileRepositoryInterface
{
    public function getAllFilesSorted(): Collection;

    public function findFileIfExists(string $fileId): RomFile;

    public function getRomAssociatedWithFile(string $fileId): Rom;

    public function getFileByFilename(string $filename): RomFile;

    public function searchForRomMatchingFile(string $fileId): ?Rom;
}
