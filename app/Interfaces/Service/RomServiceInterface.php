<?php

namespace App\Interfaces\Service;

use App\Models\Rom;
use Utils\Modules\JsonDataResponse;

interface RomServiceInterface
{
    public function attemptToLinkRomToFile(Rom $rom): JsonDataResponse;
}