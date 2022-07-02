<?php

namespace App\Interfaces;

use App\Models\Rom;
use Utils\Modules\JsonDataResponse;

interface RomDataServiceInterface
{
    public function attemptToLinkRomToFile(Rom $rom): JsonDataResponse;
}
