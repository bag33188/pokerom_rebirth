<?php

namespace App\Interfaces;

use App\Models\Game;
use App\Models\Rom;

interface RomRepositoryInterface
{
    public function getAllRomsSorted();

    public function findRomIfExists(int $romId);

    public function getGameAssociatedWithRom(int $romId);

    public function searchForFileMatchingRom(int $romId);

    public function getFileAssociatedWithRom(int $romId);
}
