<?php

namespace App\Interfaces\Service;

use App\Models\RomFile;
use Symfony\Component\HttpFoundation\StreamedResponse;
use Utils\Modules\JsonDataResponse;

interface RomFileServiceInterface
{
    public function downloadRomFile(RomFile $romFile): StreamedResponse;

    public function uploadRomFile(string $romFilename): JsonDataResponse;

    public function deleteRomFile(RomFile $romFile): JsonDataResponse;
}
