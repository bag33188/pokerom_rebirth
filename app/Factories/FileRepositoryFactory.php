<?php

namespace App\Factories;

use App\Models\File;
use App\Models\Rom;
use Illuminate\Database\Eloquent\Collection;

interface FileRepositoryFactory
{
    public function getAllFilesSorted(): Collection;

    public function findFileIfExists(string $fileId): File;

    public function getRomAssociatedWithFile(string $fileId): Rom;

    public function getFileByFilename(string $filename): File;

    public function searchForRomMatchingFile(string $fileId): ?Rom;
}
