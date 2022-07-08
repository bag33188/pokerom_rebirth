<?php

namespace App\Interfaces\Repository;

use App\Models\Rom;
use App\Models\RomFile;
use Illuminate\Database\Eloquent\Collection;

interface RomFileRepositoryInterface
{
    public function getAllFilesSorted(): Collection;

    public function findFileIfExists(string $romFileId): RomFile;

    public function getRomAssociatedWithFile(string $romFileId): Rom;

    public function getFileByFilename(string $romFilename): RomFile;

    public function searchForRomMatchingFile(string $romFileId): ?Rom;

    public function getFileLengthsKibibytes(): Collection;

    public function getFileLengthsGibibytes(): Collection;

    public function getFileLengthsMebibytes(): Collection;

    public function getTotalSizeOfAllRomFiles(): int;

    public function getLengthOfRomFileWithLargestFileSize(): int;
}
