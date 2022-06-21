<?php

namespace App\Interfaces;

use App\Models\Rom;
use Utils\Classes\JsonDataServiceResponse;

interface RomDataServiceInterface
{
    public function attemptToLinkRomToFile(Rom $rom): JsonDataServiceResponse;

    public function linkRomToFileIfExists(Rom $rom): void;
}
