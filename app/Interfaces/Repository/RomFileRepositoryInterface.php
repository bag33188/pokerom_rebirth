<?php

namespace App\Interfaces\Repository;

use App\Models\Rom;
use App\Models\RomFile;
use Illuminate\Database\Eloquent\Collection;

interface RomFileRepositoryInterface
{
    public function getAllFilesSorted(): Collection;

    public function findFileIfExists(string $fileId): RomFile;

    public function getRomAssociatedWithFile(string $fileId): Rom;

    public function getFileByFilename(string $filename): RomFile;

    public function searchForRomMatchingFile(string $fileId): ?Rom;

    public function getFileLengthsKibibytes(): Collection;

    public function getFileLengthsGibibytes(): Collection;

    public function getFileLengthsMebibytes(): Collection;

    public function calcTotalSizeOfAllRomFiles(): int;
}
