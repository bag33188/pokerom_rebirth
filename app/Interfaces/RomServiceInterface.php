<?php

namespace App\Interfaces;

use App\Models\Rom;
use Classes\JsonDataServiceResponse;

interface RomServiceInterface
{
    public function attemptToLinkRomToFile(Rom $rom): JsonDataServiceResponse;

    public function linkRomToFileIfExists(Rom $rom): void;
}
