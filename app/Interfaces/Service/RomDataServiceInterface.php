<?php

namespace App\Interfaces\Service;

use App\Models\Rom;
use Utils\Classes\JsonDataResponse;

interface RomDataServiceInterface
{
    public function attemptToLinkRomToFile(Rom $rom): JsonDataResponse;
}
