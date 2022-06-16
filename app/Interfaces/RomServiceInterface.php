<?php

namespace App\Interfaces;

use App\Models\Rom;

interface RomServiceInterface {
    public function tryToLinkRomToFile(Rom $rom);
}
