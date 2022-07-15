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

    public function getRomFileByFilename(string $romFilename): ?RomFile;

    public function getRomFileLengthsKibibytes(): Collection;

    public function getRomFileLengthsGibibytes(): Collection;

    public function getRomFileLengthsMebibytes(): Collection;

    public function getTotalSizeOfAllRomFiles(): int;

    public function getLengthOfRomFileWithLargestFileSize(): int;

    public function countRomFiles(): int;
}
