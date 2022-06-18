<?php

namespace App\Interfaces;

use App\Models\Rom;

interface RomServiceInterface
{
    public function attemptToLinkRomToFile(Rom $rom);

    public function linkRomToFileIfExists(Rom $rom);
}
