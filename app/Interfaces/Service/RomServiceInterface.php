<?php

namespace App\Interfaces\Service;

use App\Models\Rom;

interface RomServiceInterface
{
    public function linkRomToRomFileIfExists(Rom $rom): bool;
}
