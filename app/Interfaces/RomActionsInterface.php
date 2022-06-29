<?php

namespace App\Interfaces;

use App\Models\Rom;
use App\Models\RomFile;

interface RomActionsInterface
{
    public function setRomDataFromFile(Rom $rom, RomFile $file): void;

    public function linkRomToFileIfExists(Rom $rom): void;
}
