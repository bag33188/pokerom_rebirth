<?php

namespace App\Interfaces\Service;

use App\Models\Rom;
use Utils\Modules\JsonDataResponse;

interface RomDataServiceInterface
{
    public function attemptToLinkRomToFile(Rom $rom): JsonDataResponse;
}
