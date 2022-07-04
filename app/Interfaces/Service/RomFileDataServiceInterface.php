<?php

namespace App\Interfaces\Service;

use App\Models\RomFile;
use Symfony\Component\HttpFoundation\StreamedResponse;
use Utils\Modules\JsonDataResponse;

interface RomFileDataServiceInterface
{
    public function downloadRomFile(RomFile $romFile): StreamedResponse;

    public function uploadRomFile(string $filename): JsonDataResponse;

    public function deleteRomFile(RomFile $romFile): JsonDataResponse;
}
