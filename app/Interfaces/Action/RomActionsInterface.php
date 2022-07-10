<?php

namespace App\Interfaces\Action;

use App\Models\Rom;
use App\Models\RomFile;

interface RomActionsInterface
{
    public function setRomDataFromRomFileData(Rom $rom, RomFile $romFile): void;

    public function linkRomToFileIfExists(Rom $rom): void;
}
