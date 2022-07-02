<?php

namespace App\Interfaces;

use App\Models\Rom;
use App\Models\RomFile;

interface RomActionsInterface
{
    public function setRomDataFromFile(Rom $rom, RomFile $romFile): void;

    public function linkRomToFileIfExists(Rom $rom): void;
}
