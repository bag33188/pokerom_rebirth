<?php

namespace App\Interfaces\Repository;

use App\Models\Game;
use App\Models\Rom;
use App\Models\RomFile;
use Illuminate\Database\Eloquent\Collection;

interface RomRepositoryInterface
{
    public function getAllRomsSorted(): Collection;

    public function getSingleRomWithGameInfo(int $romId): Rom;

    public function getRomsWithGameAndFileInfo(): Collection;

    public function findRomIfExists(int $romId): Rom;

    public function getGameAssociatedWithRom(int $romId): Game;

    public function searchForFileMatchingRom(int $romId): ?RomFile;

    public function getFileAssociatedWithRom(int $romId): RomFile;

    public function getReadableRomSize(int $size): string;
}
