<?php

namespace App\Interfaces\Repository;

use App\Models\Rom;
use App\Models\RomFile;
use Illuminate\Database\Eloquent\Collection;

interface RomFileRepositoryInterface
{
    public function getAllRomFilesSorted(): Collection;

    public function getAllRomFilesSortedWithRomData(): Collection;

    public function findRomFileIfExists(string $romFileId): RomFile;

    public function getRomAssociatedWithFile(string $romFileId): Rom;

    public function findRomFileByFilename(string $romFilename): ?RomFile;

    public function getAllRomFileLengthsKibibytes(): Collection;

    public function getAllRomFileNameAndFileTypeValues(): Collection;

    public function getTotalSizeOfAllRomFiles(): int;

    public function getLengthOfRomFileWithLargestFileSize(): int;

    public function getRomFilesCount(): int;

    public function listAllFilesInStorage(): array;

    public function listRomFilesInStorage(): array;
}
