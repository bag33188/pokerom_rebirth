<?php

namespace App\Interfaces;

use App\Models\Rom;

interface RomRepositoryInterface
{
    public function tryToLinkRomToFile(Rom $rom);

    public function showAssociatedGame(int $romId);

    public function showAssociatedFile(int $romId);
}
