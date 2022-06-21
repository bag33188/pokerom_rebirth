<?php

namespace App\Interfaces;

use App\Models\Rom;
use App\Services\JsonServiceResponse;

interface RomServiceInterface
{
    public function attemptToLinkRomToFile(Rom $rom): JsonServiceResponse;

    public function linkRomToFileIfExists(Rom $rom): void;
}
