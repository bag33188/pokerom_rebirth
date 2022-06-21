<?php

namespace App\Factories;

use App\Models\File;
use App\Models\Game;
use App\Models\Rom;
use Illuminate\Database\Eloquent\Collection;

interface RomRepositoryFactory
{
    public function getAllRomsSorted(): Collection;

    public function findRomIfExists(int $romId): Rom;

    public function getGameAssociatedWithRom(int $romId): Game;

    public function searchForFileMatchingRom(int $romId): ?File;

    public function getFileAssociatedWithRom(int $romId): File;
}
